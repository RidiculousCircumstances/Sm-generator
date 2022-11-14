<?php

namespace Rc\SmGenerator\Writers;

use Error;
use Rc\SmGenerator\Exceptions\SitemapException;


/**
 * Aggregates the common logic of writing files of any types.
 */
abstract class Writer
{
    private static string $defaultPath = './';
    protected static string $ext = '.';


    /**
     * Checks if the specified path exists. Creates a new folder if it doesn't.
     * If no path has been specified, the default path is used.
     * @param string|null $path
     * Current directory is used by default.
     * @throws SitemapException
     */
    protected static function setPath (string $name, ?string $path): string {

       if (empty($name)) {
           throw new SitemapException ('Empty filename', 'Output filename must be specified');
       }

       if (!is_null($path)) {
           if (!is_dir($path)) {
               mkdir($path, 777, true);
           }
           return $path . "/$name" . self::$ext . static::$ext;
       } else {
           return self::$defaultPath . "/$name" . self::$ext . static::$ext;
       }
}

    /**
     * Performs common file saving operations. Checking the content for existence, path construction and saving are here.
     * Specific content-building logic is placed at child classes.
     */
    public static function write (array $content, string $name, ?string $path): string|null
    {
        try {
            self::checkContent($content);
            $path = self::setPath($name, $path);
            $output = static::build($content);
            return self::save($path, $output);
        } catch (Error | SitemapException $e) {
            if (!$e instanceof SitemapException) {
                echo $e . PHP_EOL;
            } else {
                echo $e->getInfo() . PHP_EOL;
            }
            return null;
        }
    }

    /**
     *Saves prepared data to the file on the specified path.
     * @throws SitemapException
     */
    protected static function save (string $path, string $content): string {
        $result = file_put_contents($path, $content);
        if (empty($result)) {
            throw new SitemapException('Saving failure', "Unable to save file '$path'");
        } else {
            echo "File '$path' has been successfully saved\n";
            return $path;
        }
    }

    /**
     * Checks if the content is empty.
     * @throws SitemapException
     */
    protected static function checkContent (array $content): void
    {
        if (empty($content)) {
            throw new SitemapException('Empty content', 'Page data should not be empty');
        }
    }

    /**
     * Delegates implementation of content building logic pertaining to data formats.
     * @param array $content
     * @return string
     */
    abstract protected static function build (array $content): string;

}