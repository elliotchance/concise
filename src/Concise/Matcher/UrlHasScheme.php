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
        return true;
    }

    public function getTags()
    {
        return array(Tag::URLS);
    }
}
