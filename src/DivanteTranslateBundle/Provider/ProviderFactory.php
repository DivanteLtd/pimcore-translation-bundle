<?php
/**
 * @author Piotr Rugała <piotr@isedo.pl>
 * @copyright Copyright (c) 2021 Divante Ltd. (https://divante.co)
 */

declare(strict_types=1);

namespace DivanteTranslateBundle\Provider;

final class ProviderFactory
{
    private iterable $providers;

    public function __construct(iterable $providers)
    {
       $this->providers = $providers;
    }

    public function get(string $name): ProviderInterface
    {
        /** @var ProviderInterface $provider */
        foreach ($this->providers as $provider) {
            if ($provider->getName() === $name) {
                return $provider;
            }

            // TODO throw notimplemented
        }
    }
}
