<?php

namespace App\Report\Context;

use App\Report\ReportGenerateContextInterface;

class StreamContext implements ReportGenerateContextInterface
{
    public function __construct(public $resourceStreamHandler)
    {
    }
}
