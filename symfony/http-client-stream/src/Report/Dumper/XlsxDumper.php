<?php

namespace App\Report\Dumper;

use App\Report\ReportDumperInterface;
use App\Report\ReportGenerateContextInterface;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

class XlsxDumper implements ReportDumperInterface
{
    /**
     * @inheritDoc
     */
    public function dump(iterable $reportData, ReportGenerateContextInterface $context): void
    {
        $writer = WriterEntityFactory::createXLSXWriter();
        $writer->setShouldUseInlineStrings(true);
        $writer->openToFile('php://output');

        $headers = ['FirstName', 'LastName', 'BirthDay', 'City', 'Country'];
        $row = WriterEntityFactory::createRowFromArray($headers);
        $writer->addRow($row);

        foreach ($reportData as $item) {
            $row = WriterEntityFactory::createRowFromArray([
                $item->firstName,
                $item->lastName,
                $item->birthDay->format('Y-m-d'),
                $item->city,
                $item->country
            ]);
            $writer->addRow($row);
        }

        $writer->close();
    }
}
