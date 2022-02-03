<?php

use App\DependencyInjection\AppExtension;
use Symfony\Component\Config\Builder\ConfigBuilderGenerator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

require_once __DIR__ . '/vendor/autoload.php';
$configFile = __DIR__ . '/var/config/Symfony/Config/AppConfig.php';

if (file_exists($configFile)) {
    require_once $configFile;
}

$containerBuilder = new ContainerBuilder();
$containerBuilder->registerExtension(new AppExtension());

$loaderPhp = new PhpFileLoader(
    $containerBuilder,
    new FileLocator(__DIR__ . '/config'),
    null,
     new ConfigBuilderGenerator(__DIR__ . '/var/config')
);

$loader = new DelegatingLoader(new LoaderResolver([$loaderPhp]));
$loader->load('app.php');
$loader->load('config.php');
$containerBuilder->compile();

$app = $containerBuilder->get(Application::class);
$app->run();
