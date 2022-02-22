<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController
{
    #[Route(path: "/page/{slug}", name: "app.page")]
    public function index(string $slug): Response
    {
        return new Response("<h1>Page Controller</h1><h3>Slug: $slug</h3>");
    }
}
