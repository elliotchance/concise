<?php

namespace Concise\Matcher;

class IsAnObject extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            '? is an object' => 'Assert value is an object.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return is_object($data[0]);
    }

    public function getTags()
    {
        return array(Tag::OBJECTS, Tag::TYPES);
    }
}
