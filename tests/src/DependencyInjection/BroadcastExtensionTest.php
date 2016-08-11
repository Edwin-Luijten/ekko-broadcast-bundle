<?php

namespace EdwinLuijten\Ekko\BroadcastBundle\Tests\DependencyInjection;

use EdwinLuijten\Ekko\BroadcastBundle\DependencyInjection\BroadcastExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class BroadcastExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions()
    {
        return [
            new BroadcastExtension()
        ];
    }

    public function testThatServiceIsLoaded()
    {
        $this->load();
        $this->assertContainerBuilderHasService('ekko.broadcast.manager');
    }
}