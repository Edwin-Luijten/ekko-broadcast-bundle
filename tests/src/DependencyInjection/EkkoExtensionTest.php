<?php

namespace EdwinLuijten\EkkoBundle\Tests\DependencyInjection;

use EdwinLuijten\EkkoBundle\DependencyInjection\EkkoExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class EkkoExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions()
    {
        return [
            new EkkoExtension()
        ];
    }

    public function testThatServiceIsLoaded()
    {
        $this->load();
        $this->assertContainerBuilderHasService('ekko.broadcast.manager');
    }
}