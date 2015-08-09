<?php

namespace Concise\Modules\Urls;

use Concise\Matcher\AbstractMatcher;

class UrlHasPart extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        $parts = array(
            'port' => PHP_URL_PORT,
            'host' => PHP_URL_HOST,
            'user' => PHP_URL_USER,
            'password' => PHP_URL_PASS,
            'path' => PHP_URL_PATH,
            'query' => PHP_URL_QUERY,
            'fragment' => PHP_URL_FRAGMENT,
        );
        parse_url($data[0]);
        foreach ($parts as $kw => $part) {
            if (strpos($syntax, $kw)) {
                return parse_url($data[0], $part) == $data[1];
            }
        }

        return parse_url($data[0], PHP_URL_SCHEME) == $data[1];
    }
}
