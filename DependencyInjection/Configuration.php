<?php

namespace EdwinLuijten\EkkoBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('ekko');

        $rootNode
            ->children()
                ->arrayNode('broadcaster')
                    ->children()
                        ->scalarNode('default')
                        ->end()
                        ->variableNode('connections')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}