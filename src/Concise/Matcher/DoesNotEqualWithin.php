<?php

namespace Concise\Matcher;

class DoesNotEqualWithin extends EqualsWithin
{
    public function supportedSyntaxes()
    {
        return array(
            '?:number does not equal ?:number within ?:number' => 'Assert two values are not close to each other.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
