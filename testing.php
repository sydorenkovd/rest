<?php

require __DIR__.'/vendor/autoload.php';

use Guzzle\Http\Client;

// create our http client (Guzzle)
$client = new Client('http://localhost:8000', array(
    'request.options' => array(
        'exceptions' => false,
    )
));
//$name = 'Viktor'. rand(1,100);
//$data = [
//    'name' => $name,
//    'age' => 23
//];
//$request = $client->post('api/programmers', null, json_encode($data));
//$response = $request->send();
//
//$uri = $response->getHeader('Location');
//$request = $client->get($uri);
//$response = $request->send();


$request = $client->get('/api/programmers');
$response = $request->send();
echo $response;
echo "\n\n";

