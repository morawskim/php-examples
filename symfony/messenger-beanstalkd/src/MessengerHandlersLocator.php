<?php

namespace App;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Handler\HandlerDescriptor;
use Symfony\Component\Messenger\Handler\HandlersLocatorInterface;

class MessengerHandlersLocator implements HandlersLocatorInterface
{
    public function getHandlers(Envelope $envelope): iterable
    {
        yield new HandlerDescriptor(static function (SampleMessage $sampleMessage) {
            echo 'Handling message with id #' . $sampleMessage->id . PHP_EOL;
            sleep(3);
        });
    }
}
