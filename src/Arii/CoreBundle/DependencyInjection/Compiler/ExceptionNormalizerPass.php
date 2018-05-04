<?php

namespace Arii\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ExceptionNormalizerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
/*        
        $exceptionListenerDefinition = $container->findDefinition('arii.exception_subscriber');
        $normalizers = $container->findTaggedServiceIds('arii.normalizer');

        foreach ($normalizers as $id => $tags) {
            $exceptionListenerDefinition->addMethodCall('addNormalizer', [new Reference($id)]);
        }
 */
    }
}