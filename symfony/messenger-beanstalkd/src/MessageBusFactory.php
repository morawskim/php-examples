<?php

namespace App;

use Pheanstalk\Pheanstalk;
use Symfony\Component\Messenger\Bridge\Beanstalkd\Transport\BeanstalkdTransport;
use Symfony\Component\Messenger\Bridge\Beanstalkd\Transport\Connection;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Middleware\SendMessageMiddleware;

class MessageBusFactory
{
    public static function getBeanstalkdTransport(string $host, int $port, string $tubeName): BeanstalkdTransport
    {
        return new BeanstalkdTransport(
            new Connection(
                [
                    'tube_name' => $tubeName,
                    'timeout' => 0,
                    'ttr' => 90,
                ],
                Pheanstalk::create($host, $port)
            )
        );
    }

    public static function createMessageBus(string $host, int $port, string $tubeName): MessageBusInterface
    {
        $transport = self::getBeanstalkdTransport($host, $port, $tubeName);

        $middlewares = [
            new SendMessageMiddleware(
                new MessengerSendersLocator($transport)
            ),
            new HandleMessageMiddleware(new MessengerHandlersLocator())
        ];

        return new MessageBus($middlewares);
    }
}
