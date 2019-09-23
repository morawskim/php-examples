<?php

namespace App\Form\DataTransformer;

use App\Model\DateRange;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

class DateRangeTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        if (null === $value) {
            return null;
        }

        if ($value instanceof DateRange) {
            return $value;
        }

        throw new UnexpectedTypeException($value, DateRange::class);
    }

    public function reverseTransform($value)
    {
        if (is_string($value)) {
            return $this->parseInputString($value);
        }

        if (null === $value) {
            return null;
        }

        throw new UnexpectedTypeException($value, 'string');
    }

    private function parseInputString(string $input): DateRange
    {
        $dates = explode(' - ', $input, 2);
        if (count($dates) !== 2) {
            throw new UnexpectedTypeException($input, 'string');
        }
        $dates = array_map('trim', $dates);

        $from = \DateTimeImmutable::createFromFormat('Y-m-d', $dates[0]);
        $to = \DateTimeImmutable::createFromFormat('Y-m-d', $dates[1]);

        return new DateRange($from, $to);
    }
}
