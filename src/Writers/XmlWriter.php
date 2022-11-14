<?php

namespace Rc\SmGenerator\Writers;

use DOMAttr;
use DOMDocument;
use Error;
use Rc\SmGenerator\Exceptions\SitemapException;

final class XmlWriter extends Writer
{
    protected static string $ext = 'xml';

    public static function build (array $content): string {
        $dom = new DOMDocument();
        $dom->encoding = 'utf-8';
        $dom->xmlVersion = '1.0';
        $dom->formatOutput = true;
        $root = $dom->createElement('urlset');
        $xmlnsXsi = new DOMAttr('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $xmlns = new DOMAttr('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $xsiSchemaLocation = new DOMAttr('xsi:schemaLocation', 'http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd');
        $root->setAttributeNode($xmlnsXsi);
        $root->setAttributeNode($xmlns);
        $root->setAttributeNode($xsiSchemaLocation);
        foreach ($content as $record) {
            $url = $dom->createElement('url');
            $root->appendChild($url);
            foreach ($record as $key => $value) {
                $tag = $dom->createElement($key, $value);
                $url->appendChild($tag);
            }
        }
        $dom->appendChild($root);
        $result = $dom->saveXML();
        if (is_bool($result)) {
            throw new Error('Unknown error occurred during XML-building');
        } else {
            return $result;
        }

    }

}