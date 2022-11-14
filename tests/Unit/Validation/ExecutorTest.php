<?php

namespace Tests\Unit\Validation;

use PHPUnit\Framework\TestCase;
use Rc\SmGenerator\Exceptions\SitemapException;
use Rc\SmGenerator\Sitemap;
use Rc\SmGenerator\Validation\Executor;
use Rc\SmGenerator\Validation\PageData;


class ExecutorTest extends TestCase
{
    public static array $correctData = [
        'loc' => 'ftp://site.su',
        'lastmod' => '2020-11-12',
        'changefreq' => 'daily',
        'priority' => '0.1',
    ];
    public static array $incorrectDataLoc = [
        'loc' => 'wrong://site.ru',
        'lastmod' => '2020-11-12',
        'changefreq' => 'daily',
        'priority' => '0.1',
    ];
    public static array $incorrectDataLastmod = [
        'loc' => 'https://site.ru',
        'lastmod' => '2020-44-44',
        'changefreq' => 'yearly',
        'priority' => '0.1',
    ];
    public static array $incorrectDataChangefreq = [
        'loc' => 'ftp://site.ru',
        'lastmod' => '2020-11-11',
        'changefreq' => 'wrong',
        'priority' => '0.1',
    ];
    public static array $incorrectDataPriority = [
        'loc' => 'ftp://site.ru',
        'lastmod' => '2020-11-11',
        'changefreq' => 'monthly',
        'priority' => '100',
    ];

    public function testValidateSuccess () {
        $result = Executor::validate(new PageData(...self::$correctData));
        $this->assertEquals($result, self::$correctData);
    }

    public function testValidateFailedLoc () {
        $result = Executor::validate(new PageData(...self::$incorrectDataLoc));
        $this->assertEquals(null, $result);
    }

    public function testValidateFailedLastmod () {
        $result = Executor::validate(new PageData(...self::$incorrectDataLastmod));
        $this->assertEquals(null, $result);
    }

    public function testValidateFailedChangeFreq () {
        $result = Executor::validate(new PageData(...self::$incorrectDataChangefreq));
        $this->assertEquals(null, $result);
    }

    public function testValidateFailedPriority () {
        $result = Executor::validate(new PageData(...self::$incorrectDataPriority));
        $this->assertEquals(null, $result);
    }

}