<?php

declare(strict_types=1);

namespace Tests\DivanteTranslationBundle\Provider;

use DivanteTranslationBundle\Provider\DeeplProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class DeeplProviderTest extends TestCase
{
    private DeeplProvider $deeplProvider;

    public function setUp(): void
    {
        $correctResponse = [
            'data' => [
                'translations' => [
                    [
                        'text' => 'test'
                    ],
                ],
            ],
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($correctResponse)),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $this->deeplProvider = $this->getMockBuilder(DeeplProvider::class)->getMock();
        $this->deeplProvider->method('getHttpClient')->willReturn($client);
    }

    public function testTranslate(): void
    {
        $this->assertSame('test', $this->deeplProvider->translate('test', 'en'));
    }
}
