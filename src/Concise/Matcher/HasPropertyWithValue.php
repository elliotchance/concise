<?php

namespace Concise\Matcher;

class HasPropertyWithValue extends HasProperty
{
    public function supportedSyntaxes()
    {
        return array(
            '?:object has property ?:string with value ?' => 'Assert that an object has a property with a specific value.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return parent::match(null, $data);
    }

    public function getTags()
    {
        return array(Tag::OBJECTS);
    }
}
