<?php

namespace EdwinLuijten\Ekko\BroadcastBundle\Tests;

use EdwinLuijten\Ekko\BroadcastBundle\DependencyInjection\BroadcastExtension;
use EdwinLuijten\Ekko\BroadcastBundle\BroadcastBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BroadcastBundleTest extends \PHPUnit_Framework_TestCase {

    public function testGetContainerExtension()
    {
        $bundle = new BroadcastBundle();
        $bundle->build(new ContainerBuilder());

        $this->assertInstanceOf(
            BroadcastExtension::class,
            $bundle->getContainerExtension()
        );
    }
}
