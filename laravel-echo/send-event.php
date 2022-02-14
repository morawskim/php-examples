<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotEnv = new \Symfony\Component\Dotenv\Dotenv();
$dotEnv->loadEnv(__DIR__ . '/.env');

$pusher = new \Pusher\Pusher($_SERVER['SOKETI_APP_KEY'], $_SERVER['SOKETI_APP_SECRET'], $_SERVER['SOKETI_APP_ID'], [
    'host' => 'soketi',
    'port' =>  '6001',
    'scheme' => 'http',
    'encrypted' => true,
    'useTLS' => false,
]);
$pusher->trigger('app', 'foo', ['id' => random_int(1, 9999)]);
