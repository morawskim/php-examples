<?php

namespace App\tests;

use App\DateRange;

class DeepCopyTest extends \PHPUnit\Framework\TestCase
{
    public function testDateRange()
    {
        $from = \DateTimeImmutable::createFromFormat('Y-m-d', '2020-01-01');
        $to = \DateTimeImmutable::createFromFormat('Y-m-d', '2020-02-01');
        $dateRange = new DateRange($from, $to);

        $deepCopy = new \DeepCopy\DeepCopy(true);
        /** @var DateRange $copy */
        $copy = $deepCopy->copy($dateRange);

        $this->assertNotSame($dateRange, $copy);
        $this->assertInstanceOf(DateRange::class, $copy);
        $this->assertNotSame($dateRange->getFrom(), $copy->getFrom());
        $this->assertNotSame($dateRange->getTo(), $copy->getTo());
    }

    public function testDateTime()
    {
        $dateTimeStr = '2020-01-01';
        $dateTime = \DateTime::createFromFormat('Y-m-d', $dateTimeStr);
        $deepCopy = new \DeepCopy\DeepCopy(true);
        /** @var \DateTime $copy */
        $copy = $deepCopy->copy($dateTime);

        $dateTime->add(new \DateInterval('P1D'));

        $this->assertNotSame($dateTime, $copy);
        $this->assertInstanceOf(\DateTime::class, $copy);
        $this->assertNotEquals($dateTime->format('Y-m-d'), $dateTimeStr);
        $this->assertEquals($copy->format('Y-m-d'), $dateTimeStr);
    }
}
