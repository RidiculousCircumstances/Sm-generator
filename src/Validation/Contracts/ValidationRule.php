<?php

namespace Rc\SmGenerator\Validation\Contracts;

interface ValidationRule
{
    public function __invoke (mixed $property, string $propertyName );
}