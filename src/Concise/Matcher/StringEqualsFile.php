<?php

namespace Concise\Matcher;

class StringEqualsFile extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            '?:string equals file ?:string' => "Compare string value with the contents of a file.",
        );
    }

    public function match($syntax, array $data = array())
    {
        throw new DidNotMatchException("File '{$data[1]}' does not exist.");
    }

    public function getTags()
    {
        return array(Tag::FILES, Tag::STRINGS);
    }
}
