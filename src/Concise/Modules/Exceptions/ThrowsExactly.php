<?php

namespace Concise\Modules\Exceptions;

use Concise\Matcher\AbstractMatcher;
use Concise\Matcher\DidNotMatchException;

class ThrowsExactly extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        try {
            $data[0]();
        } catch (\Exception $exception) {
            $exceptionClass = get_class($exception);
            if ($exceptionClass !== $data[1]) {
                throw new DidNotMatchException(
                    "Expected exactly {$data[1]} to be thrown, but $exceptionClass was thrown."
                );
            }

            return true;
        }
        throw new DidNotMatchException(
            "Expected exactly {$data[1]} to be thrown, but nothing was thrown."
        );
    }
}
