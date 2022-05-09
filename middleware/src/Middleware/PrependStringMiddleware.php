<?php

namespace acme\Middleware;

class PrependStringMiddleware implements MiddlewareInterface
{
    public function __construct(private string $value)
    {
    }

    public function __invoke(string $value, callable $next): string
    {
        $output =  $next($this->value . $value);

        return $output . $this->value;
    }
}
