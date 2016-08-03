<?php

namespace EdwinLuijten\EkkoBundle\DependencyInjection;

use EdwinLuijten\Ekko\Broadcasters\BroadcasterInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class EkkoExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $config = $this->processConfiguration(new Configuration(), $configs);

        $this->configureBroadcastManager($config['broadcaster'], $container);
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     */
    private function configureBroadcastManager(array $config, ContainerBuilder $container)
    {
        $broadcastManager = $container->getDefinition('broadcast.manager');
        $broadcastManager->addArgument($config['connections']);
        $broadcastManager->addMethodCall('setDefaultBroadcaster', [$config['default']]);

        $connection = new Definition($broadcastManager->getClass(), ['default']);
        $connection->setFactory([
            new Reference('broadcast.manager'),
            'connection',
        ]);
        $container->setDefinition('broadcast.default', $connection);

        // Add connections
        foreach ($config['connections'] as $name => $broadcaster) {
            $connection = new Definition($broadcastManager->getClass(), [$name]);
            $connection->setFactory([
                new Reference('broadcast.manager'),
                'connection',
            ]);

            $container->setDefinition('broadcast.' . $name, $connection);
        }
    }
}
