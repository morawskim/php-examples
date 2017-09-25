<?php

require_once __DIR__ . '/vendor/autoload.php';

if ($argc != 2) {
    fprintf(STDERR, "USAGE: ${argv[0]} FACEBOOK_USER_ID\n You can get facebook user id from https://findmyfbid.com/");
    exit(1);
}


$dotEnv = new \Symfony\Component\Dotenv\Dotenv();
$dotEnv->load(__DIR__ . '/.env');

$recipient = $argv[1];
$accessToken = getenv('FACEBOOK_APP_ACCESS_TOKEN');

$fb = new \Facebook\Facebook([
    'app_id' => getenv('FACEBOOK_APP_ID'),
    'app_secret' => getenv('FACEBOOK_APP_SECRET'),
]);

try {
    $template = "Hi Message";
    $param = array(
        'template' => $template,
    );
    $fb->post("/${recipient}/notifications", $param, $accessToken);

} catch (\Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch (\Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}
