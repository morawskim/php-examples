<?php

require __DIR__ . '/vendor/autoload.php';

return static function ($event) {
    echo json_encode(['info' => 'This message will be logged to CloudWatch']);

    return [
        'statusCode' => 200,
        'headers' => ['Content-Type' => 'application/json'],
        'body' => json_encode([
            'requestEvent' => $event,
        ]),
    ];
};
