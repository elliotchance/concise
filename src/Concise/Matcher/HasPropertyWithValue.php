<?php

namespace Concise\Matcher;

class HasPropertyWithValue extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            '?:object has property ?:string with value ?' => 'Assert that an object has a property with a specific value.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return array_key_exists($data[1], (array) $data[0]) && ($data[0]->{$data[1]} == $data[2]);
    }

    public function getTags()
    {
        return array(Tag::OBJECTS);
    }
}
