<?php

namespace Rc\SmGenerator\Validation\Attributes;

use Error;

use Rc\SmGenerator\Exceptions\SitemapException;
use Rc\SmGenerator\Validation\Contracts\ValidationRule;

class InRangeRule implements ValidationRule
{
    public function __construct (private readonly array $range) {

    }

    public function __invoke(mixed $property, string $propertyName)
    {
        if (!in_array($property, $this->range)) {
            $stringRange = implode(",\n", $this->range);
            throw new SitemapException('Validation failure',
            "Value '$propertyName' does not match the valid range. Valid range:\n'$stringRange'.\nGiven: $property\n");
        }
    }
}