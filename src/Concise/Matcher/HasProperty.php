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
        return isset($data[0]->$data[1]);
    }

    public function getTags()
    {
        return array(Tag::OBJECTS);
    }
}
