<?php

namespace Concise\Matcher;

class IsInstanceOf extends AbstractMatcher
{
    const DESCRIPTION = 'Assert an objects class or subclass.';

    public function supportedSyntaxes()
    {
        return array(
            '?:object,class is an instance of ?:class' => self::DESCRIPTION,
            '?:object,class is instance of ?:class' => self::DESCRIPTION,
            '?:object,class instance of ?:class' => self::DESCRIPTION,
        );
    }

    public function match($syntax, array $data = array())
    {
        $interfaces = class_implements($data[0]);

        if (is_string($data[0])) {
            return true;
        }
        return (get_class($data[0]) === $data[1]) || is_subclass_of($data[0], $data[1]) || array_key_exists($data[1], $interfaces);
    }

    public function getTags()
    {
        return array(Tag::OBJECTS, Tag::TYPES);
    }
}
