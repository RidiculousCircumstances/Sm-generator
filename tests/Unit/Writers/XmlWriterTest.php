<?php

namespace Tests\Unit\Writers;

use PHPUnit\Framework\TestCase;
use Rc\SmGenerator\Writers\XmlWriter;

class XmlWriterTest extends TestCase
{
    public static array $data = [
        'loc' => 'ftp://site.com',
        'lastmod' => '2020-11-12',
        'changefreq' => 'daily',
        'priority' => '0.1',
    ];

    public function testWriteSuccess () {
        $result = XmlWriter::write([self::$data], 'sitemap', './tests/unit/writers');
        $this->assertEquals('./tests/unit/writers/sitemap.xml', $result);
    }

    public function testWriteFailedName () {
        $result = XmlWriter::write([self::$data], '', './tests/unit/writers');
        $this->assertEquals(null, $result);
    }

    public function testWriteFailedPath () {
        $result = XmlWriter::write([self::$data], 'sitemap', '');
        $this->assertEquals(null, $result);
    }

    public function testWriteFailedContent () {
        $result = XmlWriter::write([], 'sitemap', './tests/unit/writers');
        $this->assertEquals(null, $result);
    }
}

