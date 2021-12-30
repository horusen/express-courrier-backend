<?php

namespace App\Http\Shared\Optimus\Architect\ModeResolver;

interface ModeResolverInterface
{
    public function resolve($property, &$object, &$root, $fullPropertyPath);
}
