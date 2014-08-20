<?php

namespace Concise\Matcher;

class DoesNotHaveProperty extends HasProperty
{
    public function supportedSyntaxes()
    {
        return array(
            '?:object does not have property ?:string' => 'Assert that an object does not have a property.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }

    public function getTags()
    {
        return array(Tag::OBJECTS);
    }
}
