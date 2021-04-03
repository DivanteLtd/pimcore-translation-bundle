<?php

namespace Tests\Unit\DivanteTranslationBundle\Service;

use ArrayObject;
use DivanteTranslationBundle\Exception\TranslationProviderNotImplemented;
use DivanteTranslationBundle\Provider\DeeplProvider;
use DivanteTranslationBundle\Provider\GoogleProvider;
use DivanteTranslationBundle\Provider\ProviderFactory;
use DivanteTranslationBundle\Provider\ProviderInterface;
use PHPUnit\Framework\TestCase;

final class ProviderFactoryTest extends TestCase
{
    public function testGet()
    {
        $factory = new ProviderFactory('test', $this->getProviders());

        $this->assertInstanceOf(ProviderInterface::class, $factory->get('google_translate'));
        $this->assertInstanceOf(ProviderInterface::class, $factory->get('deepl'));
    }

    public function testGetException()
    {
        $this->expectException(TranslationProviderNotImplemented::class);

        $factory = new ProviderFactory('test', $this->getProviders());
        $factory->get('test');
    }

    private function getProviders(): iterable
    {
        $providers = [
            new GoogleProvider(),
            new DeeplProvider(),
        ];

        $arrayObject = new ArrayObject($providers);
        return $arrayObject->getIterator();
    }
}
