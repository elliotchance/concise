<?php

namespace Concise\Matcher;

class HasProperty extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            '?:object has property ?:string' => 'Assert that an object has a property.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return array_key_exists($data[1], (array) $data[0]);
    }

    public function getTags()
    {
        return array(Tag::OBJECTS);
    }
}
