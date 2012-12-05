<?php

namespace KPhoen\ContactBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('k_phoen_contact');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('to')->defaultValue(null)->end()
                ->scalarNode('redirect_url')->defaultValue('homepage')
            ->end();

        return $treeBuilder;
    }
}
