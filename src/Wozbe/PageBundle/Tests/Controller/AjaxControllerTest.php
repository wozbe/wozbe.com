<?php

namespace Wozbe\PageBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AjaxControllerTest extends WebTestCase
{
    public function testAjaxContact()
    {
        $client = static::createClient();
        $client->getContainer()->get('wozbe_admin.manager.configuration')->set('page.email', 'contact@wozbe.com');

        // Submit a raw JSON string in the request body
        $client->request(
            'POST',
            '/ajax/contact',
            array(
                "email"     => "test@wozbe.com",
                "message"   => "Hello World",
            ),
            array(),
            array('HTTP_X-Requested-With' => 'XMLHttpRequest')
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
