<?php

namespace Concise\Matcher;

class HasProperty extends AbstractNestedMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            '?:object has property ?:string' => 'Assert that an object has a property. Returns the properties value.',
        );
    }

    public function match($syntax, array $data = array())
    {
        if (!array_key_exists($data[1], (array) $data[0])) {
            throw new DidNotMatchException();
        }

        return $data[0]->{$data[1]};
    }

    public function getTags()
    {
        return array(Tag::OBJECTS);
    }
}
