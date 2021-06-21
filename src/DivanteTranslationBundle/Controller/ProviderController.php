<?php

namespace DivanteTranslationBundle\Controller;

use DivanteTranslationBundle\Provider\ProviderFactory;
use Pimcore\Bundle\AdminBundle\Controller\AdminController;
use Pimcore\Bundle\AdminBundle\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
final class ProviderController extends AdminController
{
    private string $sourceLanguage;
    private string $provider;

    public function __construct(string $sourceLanguage, string $provider)
    {
        $this->sourceLanguage = $sourceLanguage;
        $this->provider = $provider;
    }

    /**
     * @Route("/translate-provider", methods={"GET"})
     */
    public function translationProviderInfoAction(): JsonResponse
    {
        return $this->adminJson([
            'provider' => $this->provider
        ]);
    }
}
