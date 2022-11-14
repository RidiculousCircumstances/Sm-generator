<?php

namespace Rc\SmGenerator\Writers;

final class CsvWriter extends Writer
{
    protected static string $ext = 'csv';

    protected static function build (array $content): string {
        $csv = '';
        $csv .= implode(',', array_keys($content[0]));
        $csv .= "\n";
        foreach ($content as $record) {
            $csv .= implode(',', $record);
            $csv .= "\n";
        }
        return $csv;
    }

}