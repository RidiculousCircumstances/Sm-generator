<?php

namespace Rc\SmGenerator;

use Error;
use Rc\SmGenerator\Exceptions\SitemapException;
use Rc\SmGenerator\Writers\CsvWriter;
use Rc\SmGenerator\Writers\JsonWriter;
use Rc\SmGenerator\Writers\XmlWriter;
use Rc\SmGenerator\Validation\PageData;

use Rc\SmGenerator\Validation\Executor;



/**
 * Allows you to convert an array of page-data such as location, last mod time, etc. into standard formats such as json, xml, csv.
 */
class Sitemap
{
    private static Sitemap $sitemap;
    private array $pages = [];
    private array $paths = [];


    /**
     * Returns singleton instance of itself.
     * @return static
     */
    public static function create (): self {
        if(isset(self::$sitemap)) {
            return self::$sitemap;
        }
        self::$sitemap = new self();
        return self::$sitemap;
    }


    /**
     *
     * Takes associative arrays of pages data and pushes them into writers if the data was valid.
     * @param list<int, array{loc: string, lastmod: string, changefreq: string, priority: string|float}> $pages
     *
     * Example: ['loc' => 'http://example.com',
     * 'lastmod' => '2022-11-11',
     * 'changefreq' => 'daily',
     * 'priority' => '0.5']
     *
     * @return $this
     */
    public function add (array $pages): Sitemap
    {
        try {
            foreach ($pages as $page) {
                $this->pages [] = Executor::validate(new PageData(
                    ...$page
                )) ?? [];
            }
        } catch (Error | SitemapException $e) {
            if (!$e instanceof SitemapException) {
                echo $e . PHP_EOL;
            } else {
                echo $e->getInfo() . PHP_EOL;
            }
        }
        return $this;
    }

    /**
     * Writes input data to json at the specified (or default) folder.
     *
     * @param string $name
     * Name of the file
     * @param string|null $path
     * Path to the file to be written. By default, it determines by current directory.
     * @return $this
     */
    public function writeToJson (string $name, string $path = null): Sitemap
    {
        $this->paths [] = JsonWriter::write($this->pages, $name, $path);
        return $this;
    }

    /**
     * Writes input data to csv at the specified (or default) folder.
     *
     * @param string $name
     * Name of the file
     * @param string|null $path
     * Path to the file to be written. By default, it determines by current directory.
     * @return $this
     */
    public function writeToCsv (string $name, string $path = null): Sitemap {
        $this->paths [] = CsvWriter::write($this->pages, $name, $path);
        return $this;
    }

    /**
     * Writes input data to xml at the specified (or default) folder.
     *
     * @param string $name
     * Name of the file
     * @param string|null $path
     * Path to the file to be written. By default, it determines by current directory.
     * @return $this
     */
    public function writeToXml (string $name, string $path = null): Sitemap {
        $this->paths [] = XmlWriter::write($this->pages, $name, $path);
        return $this;
    }

    /**
     * Returns an array of paths to created sitemap-files.
     * @return array
     */
    public function getPaths (): array
    {
        return $this->paths;
    }
}

