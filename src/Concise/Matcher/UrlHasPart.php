<?php

namespace Concise\Matcher;

class UrlHasPart extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            'url ?:string has scheme ?:string' => 'URL has scheme.',
            'url ?:string has host ?:string' => 'URL has host.',
            'url ?:string has port ?:int' => 'URL has port.',
            'url ?:string has user ?:string' => 'URL has user.',
            'url ?:string has password ?:string' => 'URL has password.',
            'url ?:string has path ?:string' => 'URL has path.',
            'url ?:string has query ?:string' => 'URL has query.',
            'url ?:string has fragment ?:string' => 'URL has fragment.',
        );
    }

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
        $url = parse_url($data[0]);
        foreach ($parts as $kw => $part) {
            if (strpos($syntax, $kw)) {
                return parse_url($data[0], $part) == $data[1];
            }
        }

        return parse_url($data[0], PHP_URL_SCHEME) == $data[1];
    }

    public function getTags()
    {
        return array(Tag::URLS);
    }
}
