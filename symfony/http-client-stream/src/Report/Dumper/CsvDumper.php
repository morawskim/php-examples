<?php

namespace App\Report\Dumper;

use App\Report\Context\StreamContext;
use App\Report\Exception\UnexpectedContextTypeException;
use App\Report\ReportDumperInterface;
use App\Report\ReportGenerateContextInterface;

class CsvDumper implements ReportDumperInterface
{
    public function dump(iterable $reportData, ReportGenerateContextInterface $context): void
    {
        if (!$context instanceof StreamContext) {
            throw new UnexpectedContextTypeException($context, StreamContext::class);
        }

        $i = 0;
        $stream = $context->resourceStreamHandler;
        $headers = ['FirstName', 'LastName', 'BirthDay', 'City', 'Country'];
        fputcsv($stream, $headers);

        foreach ($reportData as $item) {
            ++$i;
            $row = [
                $item->firstName,
                $item->lastName,
                $item->birthDay->format('Y-m-d'),
                $item->city,
                $item->country
            ];
            fputcsv($stream, $row);

            if (0 === $i % 1000) {
                fflush($stream);
            }
        }
    }
}
