<?php

namespace Tests\Unit\GoogleTranslateBundle\Controller;

use Pimcore\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

class DefaultControllerTest extends WebTestCase
{
    /** @var Client $client */
    private $client;

    protected function setUp()
    {
        $this->client = static::createClient();
    }

    public function testSomething()
    {
        $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
