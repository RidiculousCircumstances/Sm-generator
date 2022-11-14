<?php

namespace Rc\SmGenerator\Validation\Attributes;

use Error;
use Rc\SmGenerator\Exceptions\SitemapException;
use Rc\SmGenerator\Validation\Contracts\ValidationRule;

class DateRule implements ValidationRule
{
    private static string $pattern = "/^[0-9]{4}-(((0[13578]|(10|12))-(0[1-9]|[1-2][0-9]|3[0-1]))|(02-(0[1-9]|[1-2][0-9]))|((0[469]|11)-(0[1-9]|[1-2][0-9]|30)))$/";

    public function __invoke(mixed $property, string $propertyName)
    {
        if (!preg_match_all(self::$pattern, $property)) {
            throw new SitemapException('Validation failure',
                "Invalid date format in '$propertyName'. Date format must correspond to YYYY-MM-DD, '$property' given");
        }
    }
}