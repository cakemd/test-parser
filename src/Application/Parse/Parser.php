<?php

namespace CakeParser\Application\Parse;

use CakeParser\Application\Parse\ParseResult;
use CakeParser\Application\Parse\ParserException;

/**
 * Class Parser
 * @package CakeParser\Application\Parse
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class Parser implements ParserInterface
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var \DOMDocument
     */
    private $parsedHtml;

    /**
     * @param $url
     * @return ParseResult
     * @throws ParserException
     */
    public function parse($url) : ParseResult
    {
        libxml_use_internal_errors(true);

        $sourceDoc = new \DOMDocument();

        $url = $this->ltrimSlashes($url);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($html && $sourceDoc->loadHTML($html)) {

            $this->url = $url;
            $this->parsedHtml = $sourceDoc;

            $imgSrcList = $this->findAllImgSrcList();

            $aHrefList = $this->findAllAHrefList();

            return new ParseResult($imgSrcList, $aHrefList);
        } else {
            throw new ParserException('Cannot parse given url');
        }
    }

    /**
     * @param string $str
     * @return string
     */
    private function ltrimSlashes(string $str)
    {
        return ltrim($str, '/');

    }

    /**
     * @return array
     */
    private function findAllAHrefList()
    {
        return $this->getAttributeForElementsByTagName('a', 'href');
    }

    /**
     * @return string[]
     */
    private function findAllImgSrcList()
    {
        return $this->getAttributeForElementsByTagName('img', 'src');
    }

    /**
     * @param $tagName
     * @param $attributeName
     * @return array
     */
    private function getAttributeForElementsByTagName($tagName, $attributeName)
    {
        $result = [];

        /** @var \DOMNodeList $imgNodes */
        $imgNodes = $this->parsedHtml->getElementsByTagName($tagName);

        foreach ($imgNodes as $imgNode) {
            /** @var \DOMNode $imgNode */
            $domAttr = $imgNode->attributes->getNamedItem($attributeName);

            if ($domAttr instanceof \DOMAttr) {
                $result[] = $domAttr->value;
            }
        }

        return $result;
    }
}