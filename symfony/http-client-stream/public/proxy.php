<?php

use Symfony\Component\HttpClient\HttpClient;

require_once __DIR__ . '/../vendor/autoload.php';

$client = HttpClient::create();
$response = $client->request('GET', 'http://httpd/csv', ['buffer' => false]);

if (200 !== $response->getStatusCode()) {
    throw new \Exception('Expect 200 response status code');
}

$fileHandler = fopen('php://output', 'rb');

foreach ($client->stream($response) as $chunk) {
    fwrite($fileHandler, $chunk->getContent());
}

echo PHP_EOL;
echo PHP_EOL;
echo PHP_EOL;
echo sprintf('Memory peak usage: %.2F MiB', memory_get_peak_usage(true) / 1024 / 1024);
echo PHP_EOL;
