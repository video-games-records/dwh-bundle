<?php

declare(strict_types=1);

namespace VideoGamesRecords\DwhBundle\DependencyInjection;

use Exception;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class VideoGamesRecordsDwhExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.yml');
        $loader->load('creators.yml');
        $loader->load('data_providers.yml');
        $loader->load('managers.yml');
    }
}
