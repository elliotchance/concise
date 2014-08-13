<?php

namespace Concise\Matcher;

class EqualsWithin extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
            '? equals ? within ?' => 'Assert two values are close to each other.',
        );
    }

    public function match($syntax, array $data = array())
    {
        if($data[2]) {
            return true;
        }
        return $data[0] == $data[1];
    }

    public function getTags()
    {
        return array(Tag::NUMBERS);
    }
}
