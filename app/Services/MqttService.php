<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\Facades\MQTT;
use PhpMqtt\Client\Examples\Shared\SimpleLogger;
use PhpMqtt\Client\Exceptions\MqttClientException;

class MqttService
{
    private static $client = null;

    public static function connect()
    {
        if (!self::$client) {
            $host = "erpeth.com";
            $port = 1883;
            $clientId = 'laravel-client-' . uniqid();
            $username = "admin";
            $password = "Lock@Admin";

            self::$client = new MqttClient($host, $port, $clientId);

            $connectionSettings = (new ConnectionSettings)
                ->setUsername($username)
                ->setPassword($password)
                ->setKeepAliveInterval(10) 
                ->setLastWillTopic('last/will')
                ->setLastWillMessage('offline');

            self::$client->connect($connectionSettings);
        }
        
        return self::$client;
    }

    public static function publish($topic, $message, $qos = 0)
    {
        $mqtt = self::connect();
        $mqtt->publish($topic, $message, $qos);
    }

    public static function subscribe($topic, callable $callback)
    {
        $mqtt = self::connect();
        
        $mqtt->subscribe($topic, function ($topic, $message) use ($callback) {
            //echo "Received on {$topic}: {$message}\n";
            //\Log::info("Received on {$topic}: {$message}\n");
            $callback($topic, $message);
        });

        while (true) {
            $mqtt->loop(true);
        }
    }
}
