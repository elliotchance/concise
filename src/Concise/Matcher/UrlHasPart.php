<?php

namespace Concise\Matcher;

class UrlHasPart extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            'url ?:string has scheme ?:string' => 'URL has scheme.',
            'url ?:string has host ?:string' => 'URL has host.',
        );
    }

    public function match($syntax, array $data = array())
    {
        if (strpos($syntax, 'host')) {
            return parse_url($data[0], PHP_URL_HOST) == $data[1];
        }

        return parse_url($data[0], PHP_URL_SCHEME) == $data[1];
    }

    public function getTags()
    {
        return array(Tag::URLS);
    }
}
