<?php

namespace EdwinLuijten\EkkoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Validator\Tests\Fixtures\Reference;

class BroadcasterPass implements CompilerPassInterface
{

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('ekko.broadcast.manager')) {
            return;
        }

        $definition     = $container->findDefinition('ekko.broadcast.manager');
        $taggedServices = $container->findTaggedServiceIds('ekko.broadcaster');

        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                $reference = new Reference($id);
                $broadcaster = new Definition($reference);

                // Set default broadcaster if defined
                if (isset($attributes['default']) && $attributes['default'] === true) {
                    $definition->addMethodCall('setDefaultBroadcaster', $reference);
                    $container->setDefinition('broadcaster.default', $broadcaster);
                }

                $definition->addMethodCall('add', [
                    $attributes['alias'],
                    $reference
                ]);

                // Register a new definition for each broadcaster
                $container->setDefinition('broadcaster.' . $attributes['alias'], $broadcaster);
            }
        }
    }
}