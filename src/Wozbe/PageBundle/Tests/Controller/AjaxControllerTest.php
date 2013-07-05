<?php

namespace Wozbe\PageBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AjaxControllerTest extends WebTestCase
{
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
