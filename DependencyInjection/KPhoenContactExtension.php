<?php

namespace KPhoen\ContactBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class KPhoenContactExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();

        // first, choose which the stategies to use to determine the sender and
        // receiver
        $configuration = new StrategiesConfiguration();
        $strategiesConfig = $processor->processConfiguration($configuration, $configs);
        $strategies = $this->createStrategyFactories($strategiesConfig, $container);

        // then handle to main configuration part
        $configuration = new Configuration($strategies);
        $config = $this->processConfiguration($configuration, $configs);

        // start fixing providers definitions
        foreach ($strategies as $name => $factory) {
            $factory->create($container, 'contact.strategy.'.$name, $config[$name]);
        }

        // fix and load a few things
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('form.yml');
        $loader->load('listeners.yml');
        $container->setParameter('kphoen_contact.redirect_url', $config['redirect_url']);
    }

    /**
     * Creates the strategy factories.
     *
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function createStrategyFactories(array $config, ContainerBuilder $container) : array
    {
        // load bundled adapter factories
        $tempContainer = new ContainerBuilder();
        $parameterBag = $container->getParameterBag();
        $loader = new YamlFileLoader($tempContainer, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('strategy_factories.yml');

        // load user-created adapter factories
        foreach ($config['strategies'] as $factory) {
            $loader->load($parameterBag->resolveValue($factory));
        }

        return [
            'receiver' => $tempContainer->get(sprintf('contact.strategy.%s.factory', $config['receiver_strategy'])),
            'sender' => $tempContainer->get(sprintf('contact.strategy.%s.factory', $config['sender_strategy'])),
        ];
    }
}
