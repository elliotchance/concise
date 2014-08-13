<?php

namespace Concise\Matcher;

class IsNumeric extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            '? is numeric' => 'Assert value is a number or string that represents a number.',
        );
    }

    public function match($syntax, array $data = array())
    {
        return is_numeric($data[0]);
    }

    public function getTags()
    {
        return array(Tag::NUMBERS);
    }
}
