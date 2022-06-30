<?php

/**
 * @author Łukasz Marszałek <lmarszalek@divante.co>
 * @author Piotr Rugała <piotr@isedo.pl>
 * @copyright Copyright (c) 2019 Divante Ltd. (https://divante.co)
 */

declare(strict_types=1);

namespace DivanteTranslationBundle\Controller;

use ActiveDeeplGlossaryBundle\Service\ConfigurationsAccessor;
use ActiveDeeplGlossaryBundle\Service\DeeplConnector;
use ActiveDeeplGlossaryBundle\Service\GlossariesManager;
use DivanteTranslationBundle\Provider\ProviderFactory;
use KvernelandBundle\Service\DtoTransformer;
use Pimcore\Bundle\AdminBundle\Controller\AdminController;
use Pimcore\Bundle\AdminBundle\HttpFoundation\JsonResponse;
use Pimcore\Model\DataObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Yaml;

/**
 * @Route("/admin/object")
 */
final class ObjectController extends AdminController
{
    private string $sourceLanguage;
    private string $provider;

    public function __construct(
        string $sourceLanguage,
        string $provider,

    ) {
        $this->sourceLanguage = $sourceLanguage;
        $this->provider = $provider;
    }

    /**
     * @Route("/translate-field", methods={"GET"})
     */
    public function translateFieldAction(Request $request, ProviderFactory $providerFactory): JsonResponse
    {
        try {
            $object = DataObject::getById($request->get('sourceId'));

            $lang = $request->get('lang');
            $glossaryId = $this->getGlossary($lang);

            $fieldName = 'get' . ucfirst($request->get('fieldName'));

            $data = $object->$fieldName($this->sourceLanguage);

            if (!$data) {
                return $this->adminJson([
                    'success' => false,
                    'message' => 'Data are empty',
                ]);
            }

            $provider = $providerFactory->get($this->provider);
            if ($request->get('formality') && ($this->provider === 'deepl' || $this->provider === 'deepl_free')) {
                // $provider->setFormality($request->get('formality'));
            }
            $provider->setGlossaryId($glossaryId);
            $data = $provider->translate($data, $lang);
        } catch (\Throwable $exception) {
            return $this->adminJson([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }

        return $this->adminJson([
            'success' => true,
            'data' => $data,
        ]);
    }
    public function getGlossary($lang)
    {
        $lang = 'en-' . substr($lang, 0, 2);
        $configurations = Yaml::parseFile(PIMCORE_CONFIGURATION_DIRECTORY . '/active-deepl-glossaries.yaml');
        if (array_key_exists($lang, $configurations)) {
            return $configurations[$lang];
        }
        return;
    }
}
