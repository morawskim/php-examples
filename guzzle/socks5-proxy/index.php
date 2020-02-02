<?php

require_once __DIR__ . '/vendor/autoload.php';


if ($argc != 2) {
    fprintf(STDERR, "Usage %s SOCKS5_PROXY", $argv[0]);
    echo PHP_EOL;
    die(1);
}

$proxy = $argv[1];
echo 'Using socks5 server: ' . $proxy;
echo PHP_EOL;

$client = new \GuzzleHttp\Client([
    'base_uri' => 'https://ifconfig.co'
]);

$response = $client->get('/', [
    'headers' => [
        'User-Agent' => 'curl/7.60.0',
    ],
    'proxy' => "socks5://${proxy}"
]);
echo $response->getBody();
