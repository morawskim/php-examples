<?php

use Monolog\Logger;
include_once __DIR__ . '/vendor/autoload.php';

if ($argc < 2) {
    $cmd = $argv[0];
    $help = <<<EOF
Usage:
$cmd email
EOF;
    fwrite(STDERR, $help);
    exit(1);
}

$email = $argv[1];
$credentials_file = __DIR__ . '/service-account-credentials.json';

$logger = new Logger('google-api-php-client');
$logger->pushHandler(new Monolog\Handler\StreamHandler('php://stderr', Logger::DEBUG));


$client = new Google_Client();
$client->setLogger($logger);
$client->setAuthConfig($credentials_file);

$client->setApplicationName("google-apps-signatures-example");
$client->setScopes(['https://mail.google.com', 'https://www.googleapis.com/auth/gmail.modify', 'https://www.googleapis.com/auth/gmail.readonly', 'https://www.googleapis.com/auth/gmail.settings.basic']);
$client->setSubject($email);

$httpClient = $client->authorize();

$service = new Google_Service_Gmail($client);
try {
    /** @var Google_Service_Gmail_ListSendAsResponse $response */
    $response = $service->users_settings_sendAs->listUsersSettingsSendAs($email);
    /** @var Google_Service_Gmail_SendAs[] $sendAsArray */
    $sendAsArray = $response->getSendAs();
    foreach ($sendAsArray as $sendAs) {
        var_export($sendAs->toSimpleObject());
    }
} catch (Google_Service_Exception $e) {
    throw $e;
}

