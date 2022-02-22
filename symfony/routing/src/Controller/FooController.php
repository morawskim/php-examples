<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooController
{
    #[Route(path: "/foo", name: "foo")]
    public function __invoke(): Response
    {
        return new Response('<h1>Foo Controller</h1>');
    }
}
