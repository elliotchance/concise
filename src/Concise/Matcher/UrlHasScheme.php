<?php

namespace Concise\Matcher;

class UrlHasScheme extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            'url ?:string has scheme ?:string' => 'URL has scheme.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return parse_url($data[0], PHP_URL_SCHEME) === $data[1];
    }

    public function getTags()
    {
        return array(Tag::URLS);
    }
}
