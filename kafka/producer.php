<?php

use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

$brokers = $_SERVER['CLOUDKARAFKA_BROKERS'];
$username = $_SERVER['CLOUDKARAFKA_USERNAME'];
$password = $_SERVER['CLOUDKARAFKA_PASSWORD'];
$topicPrefix = $_SERVER['CLOUDKARAFKA_TOPIC_PREFIX'];
$topic = "${topicPrefix}default";

$conf = new RdKafka\Conf();
#$conf->set('log_level', (string) LOG_DEBUG);
$conf->set('debug', 'all');

$conf->set('security.protocol', "SASL_SSL");
$conf->set('sasl.mechanisms', "SCRAM-SHA-256");
$conf->set('sasl.username', $username);
$conf->set('sasl.password', $password);

$producer = $rk = new RdKafka\Producer($conf);
$rk->addBrokers($brokers);

$topic = $rk->newTopic($topic);
for ($i = 0; $i < 10; $i++) {
    $body = 'Message ' . $i . ' ' . date('Y-m-d H:i:s');
    $topic->produce(RD_KAFKA_PARTITION_UA, 0, $body);
    $producer->poll(0);
}

for ($flushRetries = 0; $flushRetries < 10; $flushRetries++) {
    $result = $producer->flush(10000);
    if (RD_KAFKA_RESP_ERR_NO_ERROR === $result) {
        break;
    }
}

if (RD_KAFKA_RESP_ERR_NO_ERROR !== $result) {
    throw new \RuntimeException('Was unable to flush, messages might be lost!');
}
