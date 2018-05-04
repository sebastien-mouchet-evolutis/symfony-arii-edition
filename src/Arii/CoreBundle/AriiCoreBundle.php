<?php

namespace Arii\CoreBundle;

use Arii\CoreBundle\DependencyInjection\Compiler\ExceptionNormalizerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AriiCoreBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ExceptionNormalizerPass());
    }
}
