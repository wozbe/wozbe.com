<?php

namespace Wozbe\PageBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function getPagesFR ()
    {
        return array (
            array('/fr'),
            array('/fr/skills'),
            array('/fr/references'),
        );
    }

    public function getPages ()
    {
        return array (
            array('/fr'),
            array('/fr/skills'),
            array('/fr/references'),
            array('/en'),
            array('/en/skills'),
            array('/en/references'),
        );
    }
    
    /**
     * @dataProvider getPages
     */
    public function testPages($url)
    {
        $client = static::createClient();
        $client->request('GET', $url);

        if(!$client->getResponse()->isSuccessful()) {
            var_dump($client->getResponse()); exit;
        }
                
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

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Informations Légales")')->count());
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
