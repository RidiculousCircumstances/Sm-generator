<?php

namespace Rc\SmGenerator\Writers;

use Error;
use Rc\SmGenerator\Exceptions\SitemapException;

final class JsonWriter extends Writer
{
    protected static string $ext = 'json';

    protected static function build (array $content): string
    {
        return json_encode($content, JSON_PRETTY_PRINT);
    }
}