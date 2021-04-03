<?php

declare(strict_types=1);

namespace Tests\DivanteTranslationBundle\Provider;

use DivanteTranslationBundle\Exception\TranslationException;
use DivanteTranslationBundle\Provider\GoogleProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class GoogleProviderTest extends TestCase
{
    private GoogleProvider $googleProvider;

    public function setUp(): void
    {
        $correctResponse = [
            'data' => [
                'translations' => [
                    [
                        'translatedText' => 'test'
                    ],
                ],
            ],
        ];

        $incorrectResponse = [
            'data' => [
                'error' => 'error text',
            ],
        ];

        $mock = new MockHandler([
            new Response(200, [], json_encode($correctResponse)),
            new Response(200, [], json_encode($incorrectResponse)),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $this->googleProvider = $this->getMockBuilder(GoogleProvider::class)->getMock();
        $this->googleProvider->method('getHttpClient')->willReturn($client);
    }

    public function testTranslate(): void
    {
        $this->assertSame('test', $this->googleProvider->translate('test', 'en'));
    }

    public function testTranslateError(): void
    {
        $this->expectException(TranslationException::class);

        $this->googleProvider->translate('test', 'en');
    }
}
