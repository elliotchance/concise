<?php

namespace Concise\Matcher;

class IsTrue extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            '? is true' => 'Assert a value is true.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return $data[0] === true;
    }

    public function getTags()
    {
        return array(Tag::BOOLEANS, Tag::TYPES);
    }
}
