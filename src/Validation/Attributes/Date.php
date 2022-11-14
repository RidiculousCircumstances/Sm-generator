<?php

namespace Rc\SmGenerator\Validation\Attributes;

use Attribute;
use Rc\SmGenerator\Validation\Contracts\ValidationAttribute;
use Rc\SmGenerator\Validation\Contracts\ValidationRule;

/**
 * Checks if the given property has a valid date format
 */

#[Attribute(Attribute::TARGET_PROPERTY)]
class Date implements ValidationAttribute
{

    public function getValidator(): ValidationRule
    {
        return new DateRule();
    }
}