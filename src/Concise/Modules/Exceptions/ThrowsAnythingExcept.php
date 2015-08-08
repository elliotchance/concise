<?php

namespace Concise\Modules\Exceptions;

use Concise\Matcher\AbstractMatcher;
use Concise\Matcher\DidNotMatchException;

class ThrowsAnythingExcept extends AbstractMatcher
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
        } catch (\Exception $exception) {
            $exceptionClass = get_class($exception);
            if ($exceptionClass === $data[1]) {
                throw new DidNotMatchException(
                    "Expected any exception except {$data[1]} to be thrown, but $exceptionClass was thrown."
                );
            }

            return false;
        }

        return true;
    }

    public function getTags()
    {
        return array();
    }
}
