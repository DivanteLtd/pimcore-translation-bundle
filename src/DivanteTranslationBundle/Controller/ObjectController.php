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
            $field = $request->get('fieldName');
            $formality = $request->get('formality');

            $block = $request->get('block');
            $objectBrick = $request->get('objectBrick');
            if ($block) {
                $blockElementIndex = (int)$request->get('blockElementIndex');
                if (!$blockElementIndex || $blockElementIndex == '') {
                    throw new \Exception('Invalid request, "blockElementIndex" not secified');
                }

                $block = $object->get($block)[$blockElementIndex];

                /** @var DataObject\Localizedfield $localizedfield */
                $localizedfield = $block['localizedfields']->getData();
                $data = $localizedfield->getLocalizedValue($field, $lang) ?:
                    $localizedfield->getLocalizedValue($field, $this->sourceLanguage);
            } else if($objectBrick) {
                $objectBrickField = $request->get('objectBrickField');
                if (!$objectBrickField || $objectBrickField == '') {
                    throw new \Exception('Invalid request, "objectBrickField" not secified');
                }

                /** @var DataObject\Objectbrick $objectBrick */
                $objectBrick = $object->get($field)->get($objectBrick);
                $data = $objectBrick->get($objectBrickField, $lang) ?:
                    $objectBrick->get($objectBrickField, $this->sourceLanguage);
            } else {
                $data = $object->get($field, $lang) ?: $object->get($field, $this->sourceLanguage);
            }

            if (!$data || $data == '') {
                throw new \Exception("Data are empty!");
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
