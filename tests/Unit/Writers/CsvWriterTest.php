<?php

namespace Tests\Unit\Writers;

use PHPUnit\Framework\TestCase;

use Rc\SmGenerator\Writers\CsvWriter;


class CsvWriterTest extends TestCase
{
    public static array $data = [
        'loc' => 'ftp://site.com',
        'lastmod' => '2020-11-12',
        'changefreq' => 'daily',
        'priority' => '0.1',
    ];

    public function testWriteSuccess () {
        $result = CsvWriter::write([self::$data], 'sitemap', './tests/unit/writers');
        $this->assertEquals('./tests/unit/writers/sitemap.csv', $result);
    }

    public function testWriteFailedName () {
        $result = CsvWriter::write([self::$data], '', './tests/unit/writers');
        $this->assertEquals(null, $result);
    }

    public function testWriteFailedPath () {
        $result = CsvWriter::write([self::$data], 'sitemap', '');
        $this->assertEquals(null, $result);
    }

    public function testWriteFailedContent () {
        $result = CsvWriter::write([], 'sitemap', './tests/unit/writers');
        $this->assertEquals(null, $result);
    }
}

