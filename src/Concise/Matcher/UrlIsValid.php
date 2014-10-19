<?php

namespace Concise\Matcher;

class UrlIsValid extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            'url ?:string is valid' => 'Validate URL.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return false;
    }

    public function getTags()
    {
        return array(Tag::URLS);
    }
}
