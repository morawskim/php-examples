<?php

namespace acme\Middleware;

interface MiddlewareInterface
{
    public function __invoke(string $value, callable $next);
}
