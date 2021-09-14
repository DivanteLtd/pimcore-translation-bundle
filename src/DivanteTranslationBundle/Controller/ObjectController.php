<?php
/**
 * @author Łukasz Marszałek <lmarszalek@divante.co>
 * @author Piotr Rugała <piotr@isedo.pl>
 * @copyright Copyright (c) 2019 Divante Ltd. (https://divante.co)
 */

declare(strict_types=1);

namespace DivanteTranslationBundle\Controller;

use DivanteTranslationBundle\Provider\ProviderFactory;
use Pimcore\Bundle\AdminBundle\Controller\AdminController;
use Pimcore\Bundle\AdminBundle\HttpFoundation\JsonResponse;
use Pimcore\Model\DataObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/object")
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
     * @Route("/translate-field", methods={"GET"})
     */
    public function translateFieldAction(Request $request, ProviderFactory $providerFactory): JsonResponse
    {
        $result = '';
        try {
            $object = DataObject::getById($request->get('sourceId'));
            $lang = $request->get('lang');
            $fieldName = $request->get('fieldName');
            $formality = $request->get('formality');

            $blockName = $request->get('blockName');
            if ($blockName) {
                $blockElementIndex = (int)$request->get('blockElementIndex');
                $blockName = 'get' . ucfirst($blockName);
                $block = $object->$blockName()[$blockElementIndex];

                /** @var DataObject\Localizedfield $localizedfield */
                $localizedfield = $block['localizedfields']->getData();
                $data = $localizedfield->getLocalizedValue($fieldName, $lang) ?: $localizedfield->getLocalizedValue($fieldName, $this->sourceLanguage);
            } else {
                $fieldName = 'get' . ucfirst($fieldName);
                $data = $object->$fieldName($lang) ?: $object->$fieldName($this->sourceLanguage);
            }

            $provider = $providerFactory->get($this->provider);
            if ($formality && ($this->provider === 'deepl' || $this->provider === 'deepl_free')) {
                $provider->setFormality($formality);
            }

            $data = strip_tags($data);
            $result = $provider->translate($data, $lang);

        } catch (\Throwable $exception) {
            return $this->adminJson([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }

        return $this->adminJson([
            'success' => true,
            'data' => $result,
        ]);
    }
}
