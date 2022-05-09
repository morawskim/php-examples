<?php

require_once __DIR__ . '/vendor/autoload.php';

$service = new \acme\StringService([
    new \acme\Middleware\PrependStringMiddleware('1'),
    new \acme\Middleware\PrependStringMiddleware('2'),
    new \acme\Middleware\PrependStringMiddleware('3'),
]);

echo $service->process('foo');
echo PHP_EOL;
