<?php

require_once __DIR__ . '/vendor/autoload.php';

(new \Symfony\Component\Dotenv\Dotenv())->load(
    __DIR__ . '/.env',
    __DIR__ . '/.env.local'
);

if (!empty($_POST['message']) && is_string($_POST['message'])) {
    $client = new Ably\AblyRest($_ENV['ABLY_API_KEY']);
    $channel = $client->channel($_ENV['ABLY_CHANNEL']);

    $channel->publish($_ENV['ABLY_EVENT_NAME'], $_POST['message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Ably Pub/Sub demo (publish)</title>
</head>
<body>
    <form method="post">
        <label for="txtMsg">Message to publish</label>
        <input type="text" name="message" id="txtMsg">
        <br />
        <button type="submit">Publish message</button>
    </form>
</body>
</html>
