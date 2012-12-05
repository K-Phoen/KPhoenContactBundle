<?php

namespace KPhoen\ContactBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;


class KPhoenContactExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('kphoen_contact.to', $config['to']);
        $container->setParameter('kphoen_contact.redirect_url', $config['redirect_url']);
    }
}
