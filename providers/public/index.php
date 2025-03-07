<?php

use providers\src\Provider;
use providers\src\SmartHomeProvider;
use React\Http\Message\Response;
use Psr\Http\Message\ServerRequestInterface;

require __DIR__ . '/../../vendor/autoload.php';

$app = new FrameworkX\App();

$smartHomeProvider = new SmartHomeProvider();

$app->get('/devices', function (ServerRequestInterface $request) use ($smartHomeProvider) {
    return Response::json($smartHomeProvider->getDevices());
});

$app->get('/devices/{name}', function (ServerRequestInterface $request) use ($smartHomeProvider) {
    $name = $request->getAttribute('name');
    return Response::json($smartHomeProvider->getDevice($name));
});

$app->run();