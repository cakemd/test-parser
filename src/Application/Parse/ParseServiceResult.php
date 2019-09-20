<?php

namespace CakeParser\Application\Parse;

/**
 * Class ParseServiceResult
 * @package CakeParser\Application
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class ParseServiceResult
{
    /**
     * @var mixed
     */
    private $id;

    /**
     * @var array
     */
    private $parseResultList;

    /**
     * ParseServiceResult constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
        $this->parseResultList = [];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $url
     * @param ParseResult $parseResult
     * @param string|null $parentUrl
     */
    public function add(string $url, ParseResult $parseResult, string $parentUrl = null)
    {
        $this->parseResultList[] = [$url, $parentUrl, $parseResult];
    }

    /**
     * @param callable $callback
     */
    public function each(callable $callback)
    {
        foreach ($this->parseResultList as $item) {
            $callback(...$item);
        }
    }
}