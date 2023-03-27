<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testProductList(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Pizza');

        $this->assertSelectorTextContains('h5.card-title', 'MARGHERITA');
        $this->assertCount(4, $crawler->filter('h5.card-title'));
    }
}
