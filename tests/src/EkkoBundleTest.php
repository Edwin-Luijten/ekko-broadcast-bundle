<?php

namespace EdwinLuijten\EkkoBundle\Tests;

use EdwinLuijten\EkkoBundle\DependencyInjection\EkkoExtension;
use EdwinLuijten\EkkoBundle\EkkoBundle;

class EkkoBundleTest extends \PHPUnit_Framework_TestCase {

    public function testGetContainerExtension()
    {
        $bundle = new EkkoBundle();

        $this->assertInstanceOf(
            EkkoExtension::class,
            $bundle->getContainerExtension()
        );
    }
}
