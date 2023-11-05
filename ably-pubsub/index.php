<?php
require_once __DIR__ . '/vendor/autoload.php';
(new \Symfony\Component\Dotenv\Dotenv())->load(
    __DIR__ . '/.env',
    __DIR__ . '/.env.local'
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Ably Pub/Sub demo</title>
    <script src="https://cdn.ably.com/lib/ably.min-1.js"></script>
</head>
<body>

<h1>Ably Pub/Sub demo</h1>

<a target="_blank" href="server.php">To publish message go here</a>

<h3>Event logs (you can see also console logs)</h3>
<ul id="eventList"></ul>

<script>
    async function listenForEvents() {
        const eventList = document.getElementById('eventList');

        const ably = new Ably.Realtime.Promise("<?= $_ENV['ABLY_SUBSCRIBE_KEY'] ?>");
        await ably.connection.once('connected');
        console.log('Connected to Ably!');

        // get the channel to subscribe to
        const channel = ably.channels.get("<?= $_ENV['ABLY_CHANNEL'] ?>");
        // Subscribe to a channel and event demo
        await channel.subscribe("<?= $_ENV['ABLY_EVENT_NAME'] ?>", (message) => {
            const item = document.createElement("li");
            item.innerHTML = message.data;
            eventList.prepend(item);

            console.log('Received a message in realtime', message);
        });
    }

    listenForEvents();
</script>
</body>
</html>
