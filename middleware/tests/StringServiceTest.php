<?php

namespace acme\Test;

use acme\Middleware\PrependStringMiddleware;
use acme\StringService;
use PHPUnit\Framework\TestCase;

class StringServiceTest extends TestCase
{
    public function testCallingMiddlewares(): void
    {
        $service = new StringService([
            new PrependStringMiddleware('1'),
            new PrependStringMiddleware('2'),
            new PrependStringMiddleware('3'),
        ]);

        $string = $service->process('foo');

        $this->assertEquals('123foo123', $string);
    }
}
