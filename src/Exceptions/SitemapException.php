<?php

namespace Rc\SmGenerator\Exceptions;

use ErrorException;
use Throwable;

class SitemapException extends ErrorException
{
    public function __construct(public string $name, string $message = "", int $code = 0, int $severity = 1,
                                ?string $filename = __FILE__, ?int $line = __LINE__,
                                ?Throwable $previous = null,
                                )
    {
        parent::__construct($message, $code, $severity, $filename, $line, $previous);
    }

    public function getInfo (): string {
        $message = $this->getMessage();
        $trace = $this->getTrace();
        $context = end($trace)['file'];
        $line = end($trace)['line'];
        return "
Sitemap Exception:
        Name: $this->name
        Context: [$context]
        Line: $line
        Message: $message
        ";
    }
}