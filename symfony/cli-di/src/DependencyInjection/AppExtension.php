<?php

namespace App\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;

class AppExtension extends Extension implements CompilerPassInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $processor = new Processor();
        $config = $processor->processConfiguration($configuration, $configs);

        $definition = new Definition(Application::class);
        $definition->setPublic(true);
        $definition->addMethodCall('setName', [$config['app_name']]);
        $definition->addMethodCall('setVersion', [$config['app_version']]);

        $container->setDefinition(Application::class, $definition);
    }

    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition(Application::class);
        $definition->addMethodCall('addCommands', [
            array_map(static fn ($id) => new Reference($id), array_keys($container->findTaggedServiceIds('app_commands')))
        ]);
    }
}
