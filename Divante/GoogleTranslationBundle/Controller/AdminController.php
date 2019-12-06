<?php
/**
 * @date        29/09/2019 11:29
 * @author      Łukasz Marszałek <lmarszalek@divante.co>
 * @copyright   Copyright (c) 2019 Divante Ltd. (https://divante.co)
 */
namespace Divante\GoogleTranslationBundle\Controller;

use Pimcore\Bundle\AdminBundle\Controller\AdminController as BackendAdminController;

use Pimcore\Bundle\AdminBundle\HttpFoundation\JsonResponse;
use Pimcore\Model\DataObject;
use Pimcore\Model\DataObject\LampenWeltProduct;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package Divante\GoogleTranslationBundle\Controller
 */
class AdminController extends BackendAdminController
{

    /**
     * @Route("/admin/product/translate-field")
     * @param Request $request
     *
     * @return \Pimcore\Bundle\AdminBundle\HttpFoundation\JsonResponse
     */
    public function translateFieldAction(Request $request)
    {
        $product = DataObject::getById($request->get('sourceId'));
        if (!$product) {
            return $this->adminJson([
                'success' => false,
                'message' => 'product doesnt exist',
            ]);
        }

        $lang       = $request->get('lang');
        $sourceLang = $this->container->getParameter('divante_google_translation.source_lang');

        $fieldName = 'get' . ucfirst($request->get('fieldName'));

        $data = $product->$fieldName($lang) ? $product->$fieldName($lang) : $product->$fieldName($sourceLang);

        if (!$data) {
            return $this->adminJson([
                'success' => false,
                'message' => 'Data are empty',
            ]);
        }

        try {
            $apiKey = $this->container->getParameter('divante_google_translation.api_key');
            $url    = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q=' . rawurlencode($data) . '&source=&target=' . locale_get_primary_language($lang);

            $handle = curl_init($url);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($handle);

            $responseDecoded = json_decode($response, true);

            if($responseDecoded['error']){
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

        } catch (\Exception $exception) {
            return $this->adminJson([
                'success' => false,
                'message' => 'Field not found',
            ]);
        }

        return $this->adminJson([
            'success' => true,
            'data'    => $data,
        ]);
    }


    /**
     * @Route("/admin/product/get-field-data")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getFieldDataFromMasterAction(Request $request): JsonResponse
    {
        $product = LampenWeltProduct::getById($request->get('sourceId'));
        if (!$product) {
            return $this->adminJson([
                'success' => false,
                'message' => 'product doesnt exist',
            ]);
        }
        $sourceLang = $this->container->getParameter('divante_google_translation.source_lang');

        $fieldName = 'get' . ucfirst($request->get('fieldName'));

        try {

            $data = $product->$fieldName($sourceLang);
        } catch (\Exception $exception) {
            return $this->adminJson([
                'success' => false,
                'message' => 'Field not found',
            ]);
        }

        return $this->adminJson([
            'success' => true,
            'data'    => $data,
        ]);
    }
}
