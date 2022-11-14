<?php

namespace Rc\SmGenerator\Validation\Attributes;

use Attribute;
use Rc\SmGenerator\Validation\Contracts\ValidationAttribute;
use Rc\SmGenerator\Validation\Contracts\ValidationRule;


/**
 * Checks if the given property corresponds to a valid range.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class InRange implements ValidationAttribute
{
    public function __construct (private readonly array $range) {

    }

    public function getValidator(): ValidationRule
    {
        return new InRangeRule($this->range);
    }
}