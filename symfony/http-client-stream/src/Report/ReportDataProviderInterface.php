<?php

namespace App\Report;

use App\Report\Dto\ReportRowDto;

interface ReportDataProviderInterface
{
    /**
     * @return iterable<ReportRowDto>
     */
    public function getData(): iterable;
}
