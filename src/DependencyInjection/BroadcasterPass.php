<?php

namespace EdwinLuijten\Ekko\BroadcastBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class BroadcasterPass implements CompilerPassInterface
{

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {

        if (!$container->hasDefinition('ekko.broadcast.manager')) {
            return;
        }

        $definition     = $container->getDefinition('ekko.broadcast.manager');
        $taggedServices = $container->findTaggedServiceIds('ekko.broadcaster');

        foreach ($taggedServices as $id => $tags) {
            $this->createAliasses($id, $tags, $definition, $container);
        }
    }

    private function createAliasses($id, $tags, Definition $definition, ContainerBuilder $container)
    {
        foreach ($tags as $attributes) {
            $reference   = new Reference($id);
            $broadcaster = $container->getDefinition($reference->__toString());

            // Set default broadcaster if defined
            if (isset($attributes['default'])) {
                $this->createDefault($broadcaster, $reference, $definition, $container);
            }

            $this->addBroadcaster($broadcaster, $attributes, $reference, $definition, $container);
        }
    }

    private function createDefault(
        $broadcaster,
        Reference $reference,
        Definition $definition,
        ContainerBuilder $container
    ) {
        if (!$container->hasDefinition('ekko.broadcaster.default')) {
            $definition->addMethodCall('setDefaultBroadcaster', [$broadcaster]);
            $container->setAlias('ekko.broadcaster.default', $reference->__toString());
        }
    }

    private function addBroadcaster(
        $broadcaster,
        array $attributes,
        Reference $reference,
        Definition $definition,
        ContainerBuilder $container
    ) {
        $definition->addMethodCall(
            'add',
            [
                $attributes['alias'],
                $broadcaster
            ]
        );

        // Register an alias for each broadcaster
        if (!$container->hasDefinition('ekko.broadcaster.' . $attributes['alias'])) {
            $container->setAlias('ekko.broadcaster.' . $attributes['alias'], $reference->__toString());
        }
    }
}
