<?php

namespace Concise\Matcher;

class IsNotInstanceOf extends IsInstanceOf
{
    const DESCRIPTION = 'Assert than an object is not a class or subclass.';

    public function supportedSyntaxes()
    {
        return array(
            '?:object,class is not an instance of ?:class' => self::DESCRIPTION,
            '?:object,class is not instance of ?:class' => self::DESCRIPTION,
            '?:object,class not instance of ?:class' => self::DESCRIPTION,
        );
    }

    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
