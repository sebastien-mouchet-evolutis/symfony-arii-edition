<?php
namespace Arii\CoreBundle\Normalizer;

interface NormalizerInterface
{
    public function normalize(\Exception $exception);

    public function supports(\Exception $exception);
}
