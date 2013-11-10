<?php

namespace KPhoen\ContactBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Interface that must be implemented by the strategy factories
 *
 * @author Kévin Gomez <contact@kevingomez.fr>
 */
interface StrategyFactoryInterface
{
    /**
     * Creates the strategy, registers it and returns its id
     *
     * @param ContainerBuilder $container A ContainerBuilder instance
     * @param string $id The id of the service
     * @param array $config An array of configuration
     */
    public function create(ContainerBuilder $container, $id, array $config);

    /**
     * Adds configuration nodes for the strategy
     *
     * @param NodeDefinition $builder
     */
    public function addConfiguration(NodeDefinition $builder);
}
