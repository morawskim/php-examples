<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotEnv = new \Symfony\Component\Dotenv\Dotenv();
$dotEnv->load(__DIR__ . '/.env');

$config = [
    'botframework' => [
        'app_id' => getenv('BOTFRAMEWORK_APP_ID'),
        'app_key' => getenv('BOTFRAMEWORK_APP_KEY'),
    ]
];
\BotMan\BotMan\Drivers\DriverManager::loadDriver(\BotMan\Drivers\BotFramework\BotFrameworkDriver::class);
$botman = \BotMan\BotMan\BotManFactory::create($config);


// Give the bot something to listen for.
$botman->hears('hello', function (\BotMan\BotMan\BotMan $bot) {
    $user = $bot->getUser();
    $message = $bot->getMessage();
    /** @var \Symfony\Component\HttpFoundation\ParameterBag $payload */
    $payload = $message->getPayload();

    $bot->reply(
        sprintf(
            "Hello %s. Your id is %s.\nPayload:\n%s\n\nYour message:\n%s\n\nUser RAW INFO:\n%s",
            $user->getUsername(),
            $user->getId(),
            var_export($payload->all(), true),
            var_export([
                $message->getText(),
                $message->getRecipient(),
                $message->getSender()
            ], true),
            var_export($user->getInfo(), true)
        )
    );
});
// Start listening
$botman->listen();