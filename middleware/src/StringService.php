<?php

namespace acme;

class StringService
{
    public function __construct(private iterable $middlewares)
    {
    }

    public function process(string $value): string
    {
        $action = static fn(string $input): string => $input;
        foreach ($this->middlewares as $middleware) {
            $action = static fn(string $input): string => $middleware($input, $action);
        }

        return $action($value);
    }
}
