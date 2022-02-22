<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController
{
    #[Route(path: "/", name: "homepage")]
    public function home(): Response
    {
        return new Response('<h1>Homepage</h1><ul><li><a href="/page/bar">Page bar</a></li><li><a href="/">Homepage</a></li><li><a href="/foo">Foo</a></li></ul>');
    }
}
