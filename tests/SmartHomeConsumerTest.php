<?php

use consumers\SmartHomeConsumer;
use GuzzleHttp\Psr7\Uri;
use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Matcher\Matcher;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Standalone\MockService\MockServer;
use PhpPact\Standalone\MockService\MockServerConfig;


beforeAll(function() use (&$server, &$builder, &$config) {

        // Configure the mock server
        $config = new MockServerConfig();
        $config
            ->setConsumer('SmartHomeConsumer')
            ->setProvider('SmartHomeProvider')
            ->setHost('127.0.0.1')
            ->setPactSpecificationVersion('2.0.0')
            ->setPactDir(__DIR__ . '/../pacts')
            ->setLogLevel('ERROR');

        // Create a new interaction builder
        $builder = new InteractionBuilder($config);

        // Start Mock Server
        $server = new MockServer($config);
        $server->start();

});

afterAll(function() use (&$builder, &$server) {
    // Finalize pact
    $builder->finalize();

    // Stop Mock Server
    $server->stop();   
});


test('get device details', function () use (&$builder, &$config) {

    // Define the request
    $request = new ConsumerRequest();
    $request
        ->setMethod('GET')
        ->setPath('/devices/lamp')
        ->addHeader('Content-Type', 'application/json');

    // Define the response
    $matcher = new Matcher();
    $responseBody = [
        'id' => $matcher->like(1),
        'name' => $matcher->like('Lamp'),
        'status' => $matcher->regex('on','^(on|off)$'),
        'type' => $matcher->like('Light'),
        'room' => $matcher->like('Kitchen')
    ];
    $response = new ProviderResponse();
    $response
        ->setStatus(200)
        ->addHeader('Content-Type', 'application/json')
        ->setBody($responseBody);

    // Create the interaction
    $builder
        ->given('Get Device')
        ->uponReceiving('A get request to /devices/{name}')
        ->with($request)
        ->willRespondWith($response);

    $service = new SmartHomeConsumer(new Uri($config->getBaseUri()));
    $goodbyeResult = $service->getDevice('lamp');
    $verifyResult = $builder->verify();

    expect($verifyResult)->toBe(true);
    expect($goodbyeResult)->toBe([
        'id' => 1,
        'name' => 'Lamp',
        'status' => 'on',
        'type' => 'Light',
        'room' => 'Kitchen'
    ]);
});


test('get a list with all devices', function ()  use (&$builder, &$config) {

    // Define the request
    $request = new ConsumerRequest();
    $request
        ->setMethod('GET')
        ->setPath('/devices')
        ->addHeader('Content-Type', 'application/json');

    // Define the response
    $matcher = new Matcher();
    $responseBody = $matcher->eachLike([
        'id' => $matcher->integer(1),
        'name' => $matcher->like('Lamp'),
        'status' => $matcher->regex('on','^(on|off)$'),
        'type' => $matcher->like('Light'),
        'room' => $matcher->like('Kitchen')
    ]);
    
    $response = new ProviderResponse();
    $response
        ->setStatus(200)
        ->addHeader('Content-Type', 'application/json')
        ->setBody($responseBody);

    // Create the interaction
    $builder
        ->given('Get a list of devices')
        ->uponReceiving('A get request to /devices')
        ->with($request)
        ->willRespondWith($response);

    $service = new SmartHomeConsumer(new Uri($config->getBaseUri()));
    $goodbyeResult = $service->getDevices();
    $verifyResult = $builder->verify();

    expect($verifyResult)->toBe(true);
    expect($goodbyeResult)->toBe([
        [
            'id' => 1,
            'name' => 'Lamp',
            'status' => 'on',
            'type' => 'Light',
            'room' => 'Kitchen'
        ]
    ]);
});