<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends Controller
{
    /**
     *
     * @Route("/hello/{name}", name="hello")
     *
     * @param Request $request
     * @param $name
     */
    public function helloAction(Request $request, $name)
    {
        return $this->render('hello/hello.html.twig', [
            'name' => $name,
        ]);
    }
}
