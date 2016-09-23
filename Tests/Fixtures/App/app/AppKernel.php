<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles() : array
    {
        return array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle(),

            new KPhoen\ContactBundle\KPhoenContactBundle(),
        );
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config.yml');
    }

    /**
     * @return string
     */
    public function getCacheDir() : string
    {
        return sys_get_temp_dir().'/KPhoenContactBundle/cache';
    }

    /**
     * @return string
     */
    public function getLogDir() : string
    {
        return sys_get_temp_dir().'/KPhoenContactBundle/logs';
    }
}
