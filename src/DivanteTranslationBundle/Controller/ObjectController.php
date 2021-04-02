<?php
/**
 * @author Łukasz Marszałek <lmarszalek@divante.co>
 * @author Piotr Rugała <piotr@isedo.pl>
 * @copyright Copyright (c) 2019 Divante Ltd. (https://divante.co)
 */

declare(strict_types=1);

namespace DivanteTranslationBundle\Controller;

use DivanteTranslationBundle\Exception\TranslationException;
use DivanteTranslationBundle\Provider\ProviderFactory;
use Pimcore\Bundle\AdminBundle\Controller\AdminController;
use Pimcore\Bundle\AdminBundle\HttpFoundation\JsonResponse;
use Pimcore\Model\DataObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/object", name="divante_translation_bundle")
 */
final class ObjectController extends AdminController
{
    private string $sourceLanguage;
    private string $provider;

    public function __construct(string $sourceLanguage, string $provider)
    {
        $this->sourceLanguage = $sourceLanguage;
        $this->provider = $provider;
    }

    /**
     * @Route("/translate-field")
     */
    public function translateFieldAction(Request $request, ProviderFactory $providerFactory): JsonResponse
    {
        try {
            $object = DataObject::getById($request->get('sourceId'));

            $lang = $request->get('lang');
            $fieldName = 'get' . ucfirst($request->get('fieldName'));

            $data = $object->$fieldName($lang) ?? $object->$fieldName($this->sourceLanguage);

            if (!$data) {
                return $this->adminJson([
                    'success' => false,
                    'message' => 'Data are empty',
                ]);
            }

            $provider = $providerFactory->get($this->provider);
            $data = $provider->translate($data, $lang);
        } catch (\Throwable $exception) {
            return $this->adminJson([
                'success' => false,
                'message' => 'Something went wrong',
            ]);
        }

        return $this->adminJson([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * @Route("/get-field-data")
     */
    public function getFieldDataAction(Request $request): JsonResponse
    {
        $object = DataObject::getById($request->get('sourceId'));

        if (!$object instanceof DataObject) {
            return $this->adminJson([
                'success' => false,
                'message' => 'Object doesn\'t exist',
            ]);
        }

        $fieldName = 'get' . ucfirst($request->get('fieldName'));

        try {
            $data = $object->$fieldName($this->sourceLanguage);
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
