<?php

namespace CakeParser\Application\Parse;

/**
 * Class ParseService
 * @package CakeParser\Application\Parse
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class ParseService implements ParseServiceInterface
{
    private $parser;

    public function __construct(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    public function parse($url, int $subLevels = null)
    {
        $operationId = uniqid('parse');

        $serviceResult = new ParseServiceResult($operationId);

        $this->doParse($url, $serviceResult, $subLevels);

        return $serviceResult;
    }

    private function doParse($url, ParseServiceResult $serviceResult, int $subLevels = null, string $parentUrl = null)
    {
        try {
            $parseResult = $this->parser->parse($url);

            $serviceResult->add($url, $parseResult, $parentUrl);

            if (is_null($subLevels) || $subLevels > 1) {
                foreach ($parseResult->getAHrefList() as $link) {
                    $subLevels = is_null($subLevels) ? $subLevels : --$subLevels;
                    $this->doParse($link, $serviceResult, $subLevels, $url);
                }
            }


        } catch (ParserException $exception) {
            return false;
        }
    }
}