<?php

require_once __DIR__ . '/vendor/autoload.php';

$messageBus = \App\MessageBusFactory::createMessageBus('beanstalkd', 11300, 'foo');
$worker = new \Symfony\Component\Messenger\Worker(
    ['beanstalkd' => \App\MessageBusFactory::getBeanstalkdTransport('beanstalkd', 11300, 'foo')],
    $messageBus
);
$worker->run();
