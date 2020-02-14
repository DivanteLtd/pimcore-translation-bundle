<?php
/**
 * @date        29/09/2019 11:29
 * @author      Łukasz Marszałek <lmarszalek@divante.co>
 * @copyright   Copyright (c) 2019 Divante Ltd. (https://divante.co)
 */

namespace GoogleTranslateBundle\Controller;

use GoogleTranslateBundle\Service\ConfigurationService;
use Pimcore\Bundle\AdminBundle\Controller\AdminController as BackendAdminController;

use Pimcore\Bundle\AdminBundle\HttpFoundation\JsonResponse;
use Pimcore\Model\DataObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @Route("/admin/object")
 * @package GoogleTranslateBundle\Controller
 */
class AdminController extends BackendAdminController
{
    /**
     * @Route("/translate-field")
     * @param Request $request
     *
     * @return \Pimcore\Bundle\AdminBundle\HttpFoundation\JsonResponse
     */
    public function translateFieldAction(Request $request)
    {
        $object = DataObject::getById($request->get('sourceId'));
        if (!$object instanceof DataObject) {
            return $this->adminJson([
                'success' => false,
                'message' => 'Object doesnt exist',
            ]);
        }

        $lang = $request->get('lang');
        /** @var ConfigurationService $configuration */
        $configuration = $this->container->get(ConfigurationService::class);

        $fieldName = 'get' . ucfirst($request->get('fieldName'));

        $data = $object->$fieldName($lang) ?? $object->$fieldName($configuration->getSourceLang());

        if (!$data) {
            return $this->adminJson([
                'success' => false,
                'message' => 'Data are empty',
            ]);
        }

        try {
            $apiKey = $configuration->getApiKey();
            $url = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey .
                '&q=' . rawurlencode($data) .
                '&source=&target=' . locale_get_primary_language($lang);

            $handle = curl_init($url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($handle);

            $responseDecoded = json_decode($response, true);

            if ($responseDecoded['error']) {
                return $this->adminJson([
                    'success' => false,
                    'message' => $responseDecoded['error']['message'],
                ]);
            }

            curl_close($handle);

            $decodeData = $responseDecoded['data']['translations'][0]['translatedText'];
            if ($decodeData) {
                $data = $decodeData;
            }
        } catch (\Throwable $exception) {
            return $this->adminJson([
                'success' => false,
                'message' => 'Field not found',
            ]);
        }

        return $this->adminJson([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * @Route("/get-field-data")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getFieldDataFromMasterAction(Request $request): JsonResponse
    {
        $object = DataObject::getById($request->get('sourceId'));
        if (!$object instanceof DataObject) {
            return $this->adminJson([
                'success' => false,
                'message' => 'Object doesnt exist',
            ]);
        }
        /** @var ConfigurationService $configuration */
        $configuration = $this->container->get(ConfigurationService::class);

        $fieldName = 'get' . ucfirst($request->get('fieldName'));

        try {
            $data = $object->$fieldName($configuration->getSourceLang());
        } catch (\Throwable $exception) {
            return $this->adminJson([
                'success' => false,
                'message' => 'Field not found',
            ]);
        }

        return $this->adminJson([
            'success' => true,
            'data' => $data,
        ]);
    }
}
