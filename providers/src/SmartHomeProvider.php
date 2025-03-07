<?php

namespace providers\src;

class SmartHomeProvider
{
    private array $devices;

    public function __construct(){
        $this->devices = [
            'lamp' => [
                'id' => 1,
                'name' => 'Lamp',
                'status' => 'on',
                'type' => 'Light',
                'room' => 'Kitchen',
                'color' => 'white'
            ],
            'tv' => [
                'id' => 2,
                'name' => 'TV',
                'status' => 'off',
                'type' => 'TV',
                'room' => 'Living Room',
                'color' => 'black'
            ],
            'fridge' => [
                'id' => 3,
                'name' => 'Fridge',
                'status' => 'off',
                'type' => 'Fridge',
                'room' => 'Kitchen',
                'color' => 'white'
            ]
        ];
    }

    public function getDevice(string $deviceName): array
    {
        return $this->devices[$deviceName];
    }

    public function getDevices(): array
    {
        return array_values($this->devices);
    }
}