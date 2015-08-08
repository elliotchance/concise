<?php

namespace Concise\Modules\RegularExpressions;

use Concise\Matcher\AbstractMatcher;

class MatchesRegularExpression extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
        );
    }

    public function match($syntax, array $data = array())
    {
        return preg_match($data[1], $data[0]) === 1;
    }

    public function getTags()
    {
        return array();
    }
}
