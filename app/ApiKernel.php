<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class ApiKernel extends Kernel
{
    public function registerBundles()
    {
        // load only the bundles strictly needed for the API...
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/api/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs/api';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getProjectDir().'/app/config/api/config_'.$this->getEnvironment().'.yml');
    }
}