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
        $this->assertTrue(file_exists($webDir . '/bundles/app/images/logo-wozbe-simple.png'));
        $this->assertTrue(file_exists($webDir . '/bundles/app/images/logo-wozbe-letter.png'));
    }
    
    public function getPagesFR ()
    {
        return array (
            array('/fr'),
            array('/fr/skills'),
            array('/fr/references'),
            array('/fr/contact'),
        );
    }
    
    /**
     * @dataProvider getPagesFR
     */
    public function testPages($url)
    {
        $client = static::createClient();
        $client->request('GET', $url);
                
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
    
    public function testHomeKeywords()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/fr/skills');
        
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
    
    /**
     * @dataProvider getPagesFR
     */
    public function testLegalsInformations($url)
    {
        $client = static::createClient();

        $crawler = $client->request('GET', $url);
        
        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Informations légales")')->count());
        $this->assertGreaterThan(0, $crawler->filter('#modalInformations')->count());
    }
    
    /**
     * @dataProvider getPagesFR
     */
    public function testGAnalytics($url)
    {
        $client = static::createClient();

        $crawler = $client->request('GET', $url);
        
        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertGreaterThan(0, $crawler->filter('html:contains("GoogleAnalyticsObject")')->count());
    }
}
