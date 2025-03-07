<?php

namespace consumers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;

class SmartHomeConsumer
{
    private Client $httpClient;
    private Uri $baseUri;

    public function __construct(Uri $baseUri)
    {
        $this->baseUri    = $baseUri;
        $this->httpClient = new Client();
    }

    /**
     * Get smart device details by name
     */
    public function getDevice(string $name): array
    {
        $response = $this->httpClient->get("{$this->baseUri->__toString()}/devices/{$name}", [
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $body   = $response->getBody();
        return json_decode($body, true, 512, JSON_THROW_ON_ERROR);
    }

    /*     
     * Get smart devices list
     */
    public function getDevices(): array
    {
        $response = $this->httpClient->get("{$this->baseUri->__toString()}/devices", [
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $body   = $response->getBody();
        return json_decode($body, true, 512, JSON_THROW_ON_ERROR);
    }

}