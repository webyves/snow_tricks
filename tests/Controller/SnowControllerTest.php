<?php
namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SnowControllerTest extends WebTestCase
{
    public function testHome()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Snow Tricks")')->count());
        $this->assertGreaterThan(3, $crawler->filter('div.card')->count());

    }

    public function testContact() 
    {
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $client->request('GET', '/contact');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // test submit back with error message because of captcha
        $form = $crawler->selectButton('Envoyer')->form();
		$crawler = $client->submit($form);
        $this->assertGreaterThan(0, $crawler->filter('div.alert-danger')->count());
    }
}
