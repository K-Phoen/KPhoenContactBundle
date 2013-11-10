<?php

namespace KPhoen\ContactBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FixedStrategyFactory implements StrategyFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $definition = $container->register($id, 'KPhoen\ContactBundle\Strategy\FixedAddressStrategy');
        $definition->addArgument($config['address']);
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('address')->isRequired()->end()
            ->end()
        ;
    }
}
