<?php

namespace EdwinLuijten\EkkoBundle;

use EdwinLuijten\EkkoBundle\DependencyInjection\BroadcasterPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EkkoBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new BroadcasterPass());
    }
}
