<?php
/**
 * @author Piotr Rugała <piotr@isedo.pl>
 * @copyright Copyright (c) 2021 Divante Ltd. (https://divante.co)
 */

declare(strict_types=1);

namespace Tests\DivanteTranslationBundle\Provider;

use ArrayObject;
use DivanteTranslationBundle\Exception\TranslationProviderNotImplemented;
use DivanteTranslationBundle\Provider\DeeplFreeProvider;
use DivanteTranslationBundle\Provider\DeeplProvider;
use DivanteTranslationBundle\Provider\GoogleProvider;
use DivanteTranslationBundle\Provider\MicrosoftProvider;
use DivanteTranslationBundle\Provider\ProviderFactory;
use DivanteTranslationBundle\Provider\ProviderInterface;
use PHPUnit\Framework\TestCase;

final class ProviderFactoryTest extends TestCase
{
    public function testGet(): void
    {
        $factory = new ProviderFactory('test', $this->getProviders(), 'default');

        $this->assertInstanceOf(ProviderInterface::class, $factory->get('google_translate'));
        $this->assertInstanceOf(ProviderInterface::class, $factory->get('deepl'));
        $this->assertInstanceOf(ProviderInterface::class, $factory->get('deepl_free'));
        $this->assertInstanceOf(ProviderInterface::class, $factory->get('microsoft_translate'));
    }

    public function testGetException(): void
    {
        $this->expectException(TranslationProviderNotImplemented::class);

        $factory = new ProviderFactory('test', $this->getProviders(), 'default');
        $factory->get('test');
    }

    private function getProviders(): iterable
    {
        $providers = [
            new GoogleProvider(),
            new DeeplProvider(),
            new DeeplFreeProvider(),
            new MicrosoftProvider(),
        ];

        $arrayObject = new ArrayObject($providers);
        return $arrayObject->getIterator();
    }
}
