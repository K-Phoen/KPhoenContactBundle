<?php

namespace KPhoen\ContactBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    protected $strategies;

    public function __construct(array $strategies)
    {
        $this->strategies = $strategies;
    }

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('k_phoen_contact');
        $rootNode->ignoreExtraKeys();

        $this->addGlobalOptions($rootNode);
        $this->addStrategiesNode($rootNode);

        return $treeBuilder;
    }

    protected function addGlobalOptions(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('redirect_url')->defaultValue('homepage')->end()
            ->end();
    }

    protected function addStrategiesNode(ArrayNodeDefinition $rootNode)
    {
        foreach ($this->strategies as $name => $strategy) {
            $strategyNode = $rootNode->children()->arrayNode($name)->isRequired();

            $strategy->addConfiguration($strategyNode);
        }

        return $rootNode;
    }
}
