<?php
/**
 * @author Piotr Rugała <piotr@isedo.pl>
 * @copyright Copyright (c) 2021 Divante Ltd. (https://divante.co)
 */

declare(strict_types=1);

namespace DivanteTranslationBundle\Provider;

use DivanteTranslationBundle\Exception\TranslationProviderNotImplemented;

class ProviderFactory
{
    private string $apiKey;
    private iterable $providers;

    public function __construct(string $apiKey, iterable $providers)
    {
        $this->apiKey = $apiKey;
        $this->providers = $providers;
    }

    public function get(string $name): ProviderInterface
    {
        /** @var ProviderInterface $provider */
        foreach ($this->providers as $provider) {
            if ($provider->getName() === $name) {
                $provider->setApiKey($this->apiKey);
                return $provider;
            }
        }

        throw new TranslationProviderNotImplemented($name);
    }
}
