<?php

namespace EdwinLuijten\EkkoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class EkkoExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $definition     = $container->findDefinition('ekko.broadcast.manager');
        $taggedServices = $container->findTaggedServiceIds('ekko.broadcaster');

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $reference = new Reference($id);
                $broadcaster = $container->getDefinition($reference->__toString());

                // Set default broadcaster if defined
                if (isset($attributes['default'])) {
                    if(!$container->hasDefinition('ekko.broadcaster.default')) {
                        $definition->addMethodCall('setDefaultBroadcaster', [$broadcaster]);
                        $container->setAlias('ekko.broadcaster.default', $reference->__toString());
                    }
                }

                $definition->addMethodCall('add', [
                    $attributes['alias'],
                    $broadcaster
                ]);

                // Register an alias for each broadcaster
                if(!$container->hasDefinition('ekko.broadcaster.' . $attributes['alias'])) {
                    $container->setAlias('ekko.broadcaster.' . $attributes['alias'], $reference->__toString());
                }
            }
        }
    }
}
