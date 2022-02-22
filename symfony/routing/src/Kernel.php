<?php

namespace App;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Loader\AnnotationDirectoryLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class Kernel
{
    public function processRequest(Request $request): Response
    {
        $routeCollection = $this->loadRoutes();

        $requestContext = new RequestContext();
        $requestContext->fromRequest($request);

        return $this->runController($request, $requestContext, $routeCollection);
    }

    private function loadRoutes(): RouteCollection
    {
        $controllerDir = __DIR__ . '/../src/Controller';

        $loader = new AnnotationDirectoryLoader(
            new FileLocator([$controllerDir]),
            new AppAnnotationClassLoader(),
        );

        return $loader->load($controllerDir);
    }

    private function runController(Request $request, RequestContext $requestContext, RouteCollection $routeCollection): Response
    {
        $urlMatcher = new UrlMatcher($routeCollection, $requestContext);
        try {
            $attributes = $urlMatcher->matchRequest($request);
            $arguments = array_filter($attributes, static fn ($argName) => !str_starts_with($argName, '_'), ARRAY_FILTER_USE_KEY);

            $controller = $attributes['_controller'];

            if (str_contains($controller, '::')) {
                [$class, $method] = explode('::', $controller, 2);
                $class = new $class();

                return $class->$method(...$arguments);
            }

            $class = new $controller();
            return $class(...$arguments);
        } catch (ResourceNotFoundException $e) {
            return new Response('Not found', 404);
        } catch (MethodNotAllowedException $e) {
            return new Response('Method not allowed', 405);
        } catch (\Throwable $e) {
            return new Response('Server error: <pre>' . $e . '</pre>', 500);
        }
    }
}
