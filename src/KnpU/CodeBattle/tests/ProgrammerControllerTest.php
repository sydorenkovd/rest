<?php

/**
 * Created by PhpStorm.
 * User: sydorenkovd
 * Date: 08.08.17
 * Time: 21:40
 */
use Guzzle\Http\Client;
class ProgrammerControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testPOST()
    {
        // create our http client (Guzzle)
        $client = new Client('http://localhost:8000', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));

        $nickname = 'ObjectOrienter'.rand(0, 999);
        $data = array(
            'name' => $nickname,
            'avatarNumber' => 5,
            'age' => 5,
            'tagLine' => 'a test dev!'
        );

        $request = $client->post('/api/programmers', null, json_encode($data));
        $response = $request->send();

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));
        $data = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('nickname', $data);
    }
}