<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Rc\SmGenerator\Sitemap;

class SitemapTest extends TestCase
{
    public static array $data = [[
        'loc' => 'ftp://site.ru',
        'lastmod' => '2020-11-12',
        'changefreq' => 'daily',
        'priority' => '1',
    ],
    [
        'loc' => 'https://site.ru',
        'lastmod' => '2020-11-12',
        'changefreq' => 'hourly',
        'priority' => '0.3',
        ]
    ,
    [
        'loc' => 'http://site.ru',
        'lastmod' => '2020-11-12',
        'changefreq' => 'monthly',
        'priority' => '0.4',
    ]
        ];

    public static array $expectedPaths = [
        './tests/unit/sitemap.xml',
        './tests/unit/sitemap.csv',
        './tests/unit/sitemap.json'
    ];

    public static Sitemap|null $sitemap;

    public function setUp (): void {
        self::$sitemap = Sitemap::create();

    }

    public function tearDown(): void
    {
        parent::tearDown();
        self::$sitemap = null;
    }

    public function testGetPathsSuccess () {
        $paths = self::$sitemap->add(self::$data)
            ->writeToXml('sitemap', './tests/unit')
            ->writeToCsv('sitemap', './tests/unit')
            ->writeToJson('sitemap', './tests/unit')
            ->getPaths();
        $this->assertEquals(self::$expectedPaths, $paths);
    }

    public function testGetPathsFail () {
        $paths = self::$sitemap->add([])
            ->writeToXml('sitemap', './tests/unit')
            ->writeToCsv('sitemap', './tests/unit')
            ->writeToJson('sitemap', './tests/unit')
            ->getPaths();
        $this->assertNotEquals(self::$expectedPaths, $paths);
    }
}