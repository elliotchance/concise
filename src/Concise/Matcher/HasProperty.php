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
        $a = (array) $data[0];
        return array_Key_exists($data[1], $a);
    }

    public function getTags()
    {
        return array(Tag::OBJECTS);
    }
}
