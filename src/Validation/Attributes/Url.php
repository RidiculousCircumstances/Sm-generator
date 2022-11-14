<?php

namespace Rc\SmGenerator\Validation\Attributes;

use Attribute;
use Rc\SmGenerator\Validation\Contracts\ValidationAttribute;
use Rc\SmGenerator\Validation\Contracts\ValidationRule;

/**
 * Checks whether the given property is an url and if so, whether the property has a valid url format.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Url implements ValidationAttribute
{

    public function getValidator(): ValidationRule
    {
        return new UrlRule();
    }
}