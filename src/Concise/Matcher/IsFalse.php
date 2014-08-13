<?php

namespace Concise\Matcher;

class IsFalse extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            '? is false' => 'Assert value is false.'
        );
    }

    public function match($syntax, array $data = array())
    {
        return $data[0] === false;
    }

    public function getTags()
    {
        return array(Tag::BOOLEANS);
    }
}
