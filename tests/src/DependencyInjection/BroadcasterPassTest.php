<?php

namespace EdwinLuijten\EkkoBundle\Tests\DependencyInjection;

use EdwinLuijten\EkkoBundle\DependencyInjection\BroadcasterPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class BroadcasterPassTest extends AbstractCompilerPassTestCase
{
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->setDefinition('ekko.broadcast.manager', new Definition());
        $container->addCompilerPass(new BroadcasterPass());
    }

    public function testThatCompilerPassSetsDefaultAlias()
    {
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
        $collectingService = new Definition();
        $collectingService->addTag('ekko.broadcaster', [
            'alias' => 'test',
        ]);

        $this->setDefinition('collecting_service_id', $collectingService);

        $this->compile();

        $this->assertContainerBuilderHasAlias('ekko.broadcaster.test');
    }
}