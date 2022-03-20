<?php

namespace App\Report;

use App\Report\Context\StreamContext;
use App\Report\Dumper\CsvDumper;
use App\Report\Dumper\XlsxDumper;

class GenerateReportFacade
{
    public function __construct(
        private ReportDataProviderInterface $reportDataProvider,
        private XlsxDumper $xlsxDumper,
        private CsvDumper $csvDumper,
    ) {
    }

    public function generateXslxReportToStdout(ReportGenerateContextInterface $context): void
    {
        $this->xlsxDumper->dump($this->reportDataProvider->getData(), $context);
    }

    public function generateCsvReportToStream(StreamContext $context): void
    {
        $this->csvDumper->dump($this->reportDataProvider->getData(), $context);
    }
}
