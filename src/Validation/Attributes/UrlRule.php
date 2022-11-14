<?php

namespace Rc\SmGenerator\Validation\Attributes;

use Error;
use Rc\SmGenerator\Exceptions\SitemapException;
use Rc\SmGenerator\Validation\Contracts\ValidationRule;

class UrlRule implements ValidationRule
{
    private static string $pattern = "%^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@|\d{1,3}(?:\.\d{1,3}){3}|(?:(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)(?:\.(?:[a-z\d\x{00a1}-\x{ffff}]+-?)*[a-z\d\x{00a1}-\x{ffff}]+)*(?:\.[a-z\x{00a1}-\x{ffff}]{2,6}))(?::\d+)?(?:[^\s]*)?$%iu";

    public function __invoke(mixed $property, string $propertyName)
    {
        if (!preg_match(self::$pattern, $property)) {
            throw new SitemapException('Validation failure', "Property '$propertyName' must be an Url");
        }
    }
}