<?php

namespace Rc\SmGenerator\Validation\Contracts;

interface ValidationAttribute
{
    public function getValidator (): ValidationRule;
}