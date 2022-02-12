<?php

require_once __DIR__ . '/vendor/autoload.php';

$message = new \App\SampleMessage(random_int(1, 9999));
$messageBus = \App\MessageBusFactory::createMessageBus('beanstalkd', 11300, 'foo');
$messageBus->dispatch($message);
