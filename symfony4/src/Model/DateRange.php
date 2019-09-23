<?php

namespace App\Model;

class DateRange
{
    /** @var \DateTimeImmutable */
    private $from;

    /** @var \DateTimeImmutable */
    private $to;

    /**
     * DateRange constructor.
     * @param \DateTimeImmutable $from
     * @param \DateTimeImmutable $to
     */
    public function __construct(\DateTimeImmutable $from, \DateTimeImmutable $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getFrom(): \DateTimeImmutable
    {
        return $this->from;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getTo(): \DateTimeImmutable
    {
        return $this->to;
    }

    public function getAsString(): string
    {
        return (string)$this;
    }

    public function __toString()
    {
        return $this->getFrom()->format('Y-m-d') . ' - ' . $this->getTo()->format('Y-m-d');
    }
}
