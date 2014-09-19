<?php

namespace Concise\Matcher;

class IsFalsy extends IsTruthy
{
    public function supportedSyntaxes()
    {
        return array(
            '? is falsy' => 'Assert a value is a false-like value.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
