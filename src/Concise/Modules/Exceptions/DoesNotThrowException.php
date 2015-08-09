<?php

namespace Concise\Modules\Exceptions;

use Concise\Matcher\AbstractMatcher;
use Concise\Matcher\DidNotMatchException;
use Exception;

class DoesNotThrowException extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        try {
            $data[0]();

            return true;
        } catch (Exception $exception) {
            throw new DidNotMatchException(
                "Expected exception not to be thrown."
            );
        }
    }
}
