<?php

namespace CakeParser\Application\Url;

/**
 * Class Helper
 * @package CakeParser\Application\Url
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class Helper
{
    /**
     * @param $url
     * @return UrlParseResult
     */
    public function parseUrl($url)
    {
        $validation = false;
        $urlparts = parse_url(filter_var($url, FILTER_SANITIZE_URL));

        if (!isset($urlparts['host'])) {
            $urlparts['host'] = $urlparts['path'];
        }

        if ($urlparts['host']!=''){
            if (!isset($urlparts['scheme'])){
                $urlparts['scheme'] = 'http';
            }
            if (
                checkdnsrr($urlparts['host'], 'A')
                && in_array($urlparts['scheme'],array('http','https'))
                && ip2long($urlparts['host']) === false
            ) {
                $urlparts['host'] = preg_replace('/^www\./', '', $urlparts['host']);
                $url = $urlparts['scheme'].'://'.$urlparts['host']. "/";

                if (filter_var($url, FILTER_VALIDATE_URL) !== false && @get_headers($url)) {
                    $validation = true;
                }
            }
        }

        return new UrlParseResult(
            $validation,
            $urlparts['scheme'],
            $urlparts['host'],
            $urlparts['path'] ?? null
        );
    }
}
