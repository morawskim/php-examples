<?php

namespace App\Report;

use App\Report\Dto\ReportRowDto;

interface ReportDumperInterface
{
    /**
     * @param iterable<ReportRowDto> $reportData
     * @param ReportGenerateContextInterface $context
     *
     * @return void
     */
    public function dump(iterable $reportData, ReportGenerateContextInterface $context): void;
}
