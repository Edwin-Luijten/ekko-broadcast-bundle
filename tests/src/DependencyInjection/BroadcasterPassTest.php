<?php

namespace EdwinLuijten\Ekko\BroadcastBundle\Tests\DependencyInjection;

use EdwinLuijten\Ekko\BroadcastBundle\DependencyInjection\BroadcasterPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class BroadcasterPassTest extends AbstractCompilerPassTestCase
{
    protected function registerCompilerPass(ContainerBuilder $container)
    {

        $container->addCompilerPass(new BroadcasterPass());
    }

    public function testThatCompilerPassReturns()
    {
        $this->compile();

        $this->assertContainerBuilderNotHasService('ekko.broadcast.manager');
    }

    public function testThatCompilerPassSetsDefaultAlias()
    {
        $this->container->setDefinition('ekko.broadcast.manager', new Definition());

        $collectingService = new Definition();
        $collectingService->addTag('ekko.broadcaster', [
            'alias' => 'test',
            'default' => true,
        ]);

        $this->setDefinition('collecting_service_id', $collectingService);

        $this->compile();

        $this->assertContainerBuilderHasAlias('ekko.broadcaster.default');
        $this->assertContainerBuilderHasAlias('ekko.broadcaster.test');
    }

    public function testThatCompilerPassCollectsTags()
    {
        $this->container->setDefinition('ekko.broadcast.manager', new Definition());

        $collectingService = new Definition();
        $collectingService->addTag('ekko.broadcaster', [
            'alias' => 'test',
        ]);

        $this->setDefinition('collecting_service_id', $collectingService);

        $this->compile();

        $this->assertContainerBuilderHasAlias('ekko.broadcaster.test');
    }
}