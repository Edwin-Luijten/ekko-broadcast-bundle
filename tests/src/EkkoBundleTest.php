<?php

namespace EdwinLuijten\EkkoBundle\Tests;

use EdwinLuijten\EkkoBundle\DependencyInjection\EkkoExtension;
use EdwinLuijten\EkkoBundle\EkkoBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EkkoBundleTest extends \PHPUnit_Framework_TestCase {

    public function testGetContainerExtension()
    {
        $bundle = new EkkoBundle();
        $bundle->build(new ContainerBuilder());

        $this->assertInstanceOf(
            EkkoExtension::class,
            $bundle->getContainerExtension()
        );
    }
}
