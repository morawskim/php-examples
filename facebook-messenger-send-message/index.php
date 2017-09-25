<?php

require_once __DIR__ . '/vendor/autoload.php';

if ($argc != 2) {
    fprintf(STDERR, "USAGE: ${argv[0]} PAGE_SCOPED_USER_ID");
    exit(1);
}


$dotEnv = new \Symfony\Component\Dotenv\Dotenv();
$dotEnv->load(__DIR__ . '/.env');

$recipient = $argv[1];
$accessToken = getenv('FACEBOOK_PAGE_ACCESS_TOKEN');

$fb = new \Facebook\Facebook([
    'app_id' => getenv('FACEBOOK_APP_ID'),
    'app_secret' => getenv('FACEBOOK_APP_SECRET'),
]);

try {
   $param = array(
        "recipient" => [
            'id' => $recipient
        ],
        "message" => [
            "text" => "hello world!"
        ]
    );
    $fb->post("/me/messages", $param, $accessToken);
} catch (\Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch (\Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}
