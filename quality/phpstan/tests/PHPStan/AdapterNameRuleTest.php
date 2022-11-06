<?php

namespace App\Test\PHPStan;

use App\App\AdapterInterface;
use App\PHPStan\AdapterNameRule;
use App\PHPStan\ExamplePHPStanRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class AdapterNameRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new AdapterNameRule(AdapterInterface::class);
    }

    public function testSimpleSnakeCaseRule(): void
    {
        $this->analyse([__DIR__ . '/../_data/test_adapter_class_name_with_suffix.php'], []);
    }

    public function testReportError(): void
    {
        $this->analyse([__DIR__ . '/../_data/test_adapter_class_name_without_suffix.php'], [
            [
                'Class should have suffix "Adapter" when implement "App\App\AdapterInterface" interface', //message
                7 // error line
            ]
        ]);
    }
}
