<?php

namespace KPhoen\ContactBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class StrategiesConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder() : \Symfony\Component\Config\Definition\Builder\TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('k_phoen_contact');

        $this->addStrategiesNode($rootNode);

        return $treeBuilder;
    }

    protected function addStrategiesNode(ArrayNodeDefinition $rootNode) : \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition
    {
        $rootNode
            ->ignoreExtraKeys()
            ->fixXmlConfig('strategy', 'strategies')
            ->children()
                ->scalarNode('sender_strategy')->defaultValue('fixed')->end()
                ->scalarNode('receiver_strategy')->defaultValue('fixed')->end()
                ->arrayNode('strategies')
                    ->prototype('scalar')->end()
                ->end()
            ->end();

        return $rootNode;
    }
}
