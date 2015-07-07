<?php

namespace Concise\Matcher;

class DoesNotHaveProperty extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            '?:object does not have property ?:string' => 'Assert that an object does not have a property.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return !array_key_exists($data[1], (array)$data[0]);
    }

    public function getTags()
    {
        return array(Tag::OBJECTS);
    }
}
