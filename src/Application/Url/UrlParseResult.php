<?php

namespace CakeParser\Application\Url;

/**
 * Class UrlParseResult
 * @package CakeParser\Application\Url
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class UrlParseResult
{
    /**
     * @var bool
     */
    private $isValid;

    /**
     * @var string
     */
    private $scheme;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $path;

    /**
     * UrlParseResult constructor.
     * @param bool $isValid
     * @param string $scheme
     * @param string $host
     * @param string $path
     */
    public function __construct(bool $isValid, string $scheme, string $host, string $path = null)
    {
        $this->isValid = $isValid;
        $this->scheme = $scheme;
        $this->host = $host;
        $this->path = $path;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->isValid;
    }

    /**
     * @return string
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
