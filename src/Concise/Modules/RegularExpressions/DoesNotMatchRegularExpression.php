<?php

namespace Concise\Modules\RegularExpressions;

class DoesNotMatchRegularExpression extends MatchesRegularExpression
{
    public function match($syntax, array $data = array())
    {
        return !parent::match(null, $data);
    }
}
