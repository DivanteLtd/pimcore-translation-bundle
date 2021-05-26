<?php
/**
 * @author Piotr Rugała <piotr@isedo.pl>
 * @copyright Copyright (c) 2021 Divante Ltd. (https://divante.co)
 */

declare(strict_types=1);

namespace Tests\DivanteTranslationBundle\Provider;

use DivanteTranslationBundle\Provider\DeeplFreeProvider;
use DivanteTranslationBundle\Provider\ProviderInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class DeeplFreeProviderTest extends TestCase
{
    public function testTranslate(): void
    {
        $response = [
            'translations' => [
                [
                    'text' => 'test'
                ],
            ],
        ];

        $this->assertSame('test', $this->createProvider($response)->translate('test', 'en'));
    }

    private function createProvider(array $response): ProviderInterface
    {
        $mock = new MockHandler([
            new Response(200, [], json_encode($response)),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $provider = $this->getMockBuilder(DeeplFreeProvider::class)
            ->onlyMethods(['getHttpClient'])
            ->getMock();
        $provider->method('getHttpClient')->willReturn($client);
        $provider->setApiKey('test');
        $provider->setFormality('more');

        return $provider;
    }
}
