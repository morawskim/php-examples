<?php

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;

require_once __DIR__ . '/vendor/autoload.php';

DriverManager::loadDriver(\BotMan\Drivers\Facebook\FacebookDriver::class);


$dotEnv = new \Symfony\Component\Dotenv\Dotenv();
$dotEnv->load(__DIR__ . '/.env');

$config = [
    'facebook' => [
        'token' => getenv('FACEBOOK_TOKEN'),
        'app_secret' => getenv('FACEBOOK_APP_SECRET'),
        'verification' => getenv('FACEBOOK_VERIFICATION')
    ]
];

// Create BotMan instance
$botman = BotManFactory::create($config);

// give the bot something to listen for.
$botman->hears('hello', function (BotMan $bot) {
    $bot->reply('Hello yourself.');
});

// start listening
$botman->listen();