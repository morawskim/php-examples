<?php

namespace App;

use App\DependencyInjection\AppExtension;
use Symfony\Component\Config\Builder\ConfigBuilderGenerator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class Kernel
{
    public function run(): void
    {
        $container = $this->buildContainer();
        $app = $container->get(Application::class);
        $app->run();
    }

    private function buildContainer(): ContainerInterface
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->registerExtension(new AppExtension());

        $loaderPhp = new PhpFileLoader(
            $containerBuilder,
            new FileLocator(__DIR__ . '/../config'),
            null,
            new ConfigBuilderGenerator(__DIR__ . '/../var/config')
        );

        $loader = new DelegatingLoader(new LoaderResolver([$loaderPhp]));
        $loader->load('app.php');
        $loader->load('config.php');
        $containerBuilder->compile();

        return $containerBuilder;
    }
}
