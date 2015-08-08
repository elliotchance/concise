<?php

namespace Concise\Modules\Exceptions;

use Concise\Matcher\AbstractMatcher;
use Concise\Matcher\DidNotMatchException;
use Exception;

class ThrowsException extends AbstractMatcher
{
    public function supportedSyntaxes()
    {
        return array(
        );
    }

    public function match($syntax, array $data = array())
    {
        try {
            $data[0]();
        } catch (Exception $exception) {
            return true;
        }
        throw new DidNotMatchException("Expected exception to be thrown.");
    }

    public function getTags()
    {
        return array();
    }
}
