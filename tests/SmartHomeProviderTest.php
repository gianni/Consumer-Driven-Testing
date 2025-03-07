<?php

use PhpPact\Standalone\ProviderVerifier\Model\VerifierConfig;
use PhpPact\Standalone\ProviderVerifier\Verifier;
use React\Http\Message\Uri;    
use Symfony\Component\Process\Process;

beforeAll(function() {
    // run provider API
    $process = new Process(['php', 'providers/public/index.php']);
    $process->start();
});

test('Pact contract is verified against Pact Broker server', function () {
    $config = new VerifierConfig();
    $config->setProviderName('SmartHomeProvider');
    $config->setProviderBaseUrl(new Uri('http://127.0.0.1:8080'));
    $config->setBrokerUri(new Uri('http://pact-broker:9292'));
    $config->setPublishResults(true);
    $config->setProviderVersion('1.0.0');
    $config->setLogDirectory(__DIR__ . '/../log');

    $verifier = new Verifier($config);
    $verifier->verify('SmartHomeConsumer');

    expect(true)->toBeTrue();
})->skip('Enable this test only after you have published the pacts to the broker-pact server: composer pact-publish');

test('Pact contract is verified against Pact json files', function () {
    $config = new VerifierConfig();
    $config->setProviderName('SmartHomeProvider');
    $config->setProviderBaseUrl(new Uri('http://127.0.0.1:8080'));
    $config->setLogDirectory(__DIR__ . '/../log');

    $verifier = new Verifier($config);    
    $verifier->verifyFiles([
        __DIR__ . '/../pacts/smarthomeconsumer-smarthomeprovider.json',
    ]);

    expect(true)->toBeTrue();
});
