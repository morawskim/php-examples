<?php

namespace App\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $tree = new TreeBuilder('app');
        $rootNode = $tree->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('app_name')->isRequired()->end()
                ->scalarNode('app_version')->isRequired()->end()
            ->end();

        return $tree;
    }
}
