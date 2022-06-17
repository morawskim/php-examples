<?php

namespace App\Test\PHPStan;

use App\PHPStan\ExamplePHPStanRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class ExamplePHPStanRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new ExamplePHPStanRule();
    }

    public function testSimpleSnakeCaseRule(): void
    {
        $this->analyse([__DIR__ . '/../_data/test.php'], []);
    }

    public function testReportError(): void
    {
        $this->analyse([__DIR__ . '/../_data/test_camel_case.php'], [
            [
                'The path to resource file ("/resource/testFixtures/foo.json") should be snake_case', //message
                9 // error line
            ]
        ]);
    }
}
