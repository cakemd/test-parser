<?php

namespace CakeParser\Application\Parse;

/**
 * Class ParseResult
 * @package CakeParser\Application\Parse
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class ParseResult
{
    private $imgSrcList;

    private $aHrefList;

    /**
     * ParseResult constructor.
     * @param array $imgSrcList
     * @param array $aHrefList
     */
    public function __construct(array $imgSrcList, array $aHrefList)
    {
        $this->imgSrcList = $imgSrcList;
        $this->aHrefList = $aHrefList;
    }

    public function getImgSrcList()
    {
        return $this->imgSrcList;
    }

    public function getAHrefList()
    {
        return $this->aHrefList;
    }
}