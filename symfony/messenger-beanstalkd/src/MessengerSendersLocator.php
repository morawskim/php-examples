<?php

namespace App;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Sender\SendersLocatorInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;

class MessengerSendersLocator implements SendersLocatorInterface
{
    public function __construct(private TransportInterface $transport)
    {
    }

    public function getSenders(Envelope $envelope): iterable
    {
        yield 'beanstalkd' => $this->transport;
    }
}
