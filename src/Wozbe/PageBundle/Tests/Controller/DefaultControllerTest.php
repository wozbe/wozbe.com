<?php

namespace Wozbe\PageBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testAssets()
    {
        $client = static::createClient();
        
        $webDir = $client->getContainer()->get('kernel')->getRootDir() . '/../web';
        
        $this->assertTrue(file_exists($webDir . '/built/app/js/wozbe.js'));
        $this->assertTrue(file_exists($webDir . '/built/app/css/wozbe.css'));
        $this->assertTrue(file_exists($webDir . '/built/wozbepage/css/index.css'));
        
        $this->assertTrue(file_exists($webDir . '/bundles/app/images/logo-wozbe-full-alpha.png'));
        $this->assertTrue(file_exists($webDir . '/bundles/app/images/logo-wozbe-small.jpg'));
    }
    
    public function testHomeKeywords()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/skills');
        
        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Développement")')->count());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Architecture")')->count());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Infrastructure")')->count());
        
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Symfony")')->count());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Doctrine")')->count());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("PHPUnit")')->count());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("NodeJS")')->count());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("MongoDB")')->count());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Redis")')->count());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("ElasticSearch")')->count());
        
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Haute-Disponibilité")')->count());
        
        $this->assertGreaterThan(0, $crawler->filter('html:contains("DevOps")')->count());
    }
    
    public function testLegalsInformations()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        
        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Informations légales")')->count());
        $this->assertGreaterThan(0, $crawler->filter('#modalInformations')->count());
    }
    
    public function testGAnalytics()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        
        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertGreaterThan(0, $crawler->filter('html:contains("GoogleAnalyticsObject")')->count());
    }
    
    public function testAjaxContact()
    {
        $client = static::createClient();

        // Submit a raw JSON string in the request body
        $client->request(
            'POST',
            '/ajax/contact',
            array(),
            array(),
            array('HTTP_X-Requested-With' => 'XMLHttpRequest'),
            '{"email": "test@wozbe.com", "message": "Hello World"}'
        );
        
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertTrue($client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
        
        $responseData = json_decode($client->getResponse()->getContent(), true);
        
        $this->assertNotNull($responseData);
        $this->arrayHasKey('title', $responseData);
        $this->arrayHasKey('message', $responseData);
    }
}
