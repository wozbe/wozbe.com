<?php

namespace Wozbe\PageBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationTest extends WebTestCase
{
    public function testAssets()
    {
        $client = static::createClient();
        
        $webDir = $client->getContainer()->get('kernel')->getRootDir() . '/../web';
        
        $this->assertTrue(file_exists($webDir . '/built/app/js/wozbe.js'));
        $this->assertTrue(file_exists($webDir . '/built/app/js/wozbe.min.js'));
        $this->assertTrue(file_exists($webDir . '/built/app/css/wozbe.css'));
        $this->assertTrue(file_exists($webDir . '/built/wozbepage/css/index.css'));
        
        $this->assertTrue(file_exists($webDir . '/bundles/app/images/logo-wozbe-full-alpha.png'));
        $this->assertTrue(file_exists($webDir . '/bundles/app/images/logo-wozbe-simple.png'));
        $this->assertTrue(file_exists($webDir . '/bundles/app/images/logo-wozbe-letter.png'));
    }
}
