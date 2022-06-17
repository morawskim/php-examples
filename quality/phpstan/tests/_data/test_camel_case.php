<?php

namespace App\Test;

class Foo
{
    public function testFoo(): void
    {
        $content = file_get_contents(__DIR__ . '/resource/testFixtures/foo.json');
    }
}
