<?php

namespace Concise\Modules\Files;

use Concise\Matcher\AbstractMatcher;
use Concise\Matcher\DidNotMatchException;

class StringEqualsFile extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        if (!file_exists($data[1])) {
            throw new DidNotMatchException("File '{$data[1]}' does not exist.");
        }

        return $data[0] == file_get_contents($data[1]);
    }
}
