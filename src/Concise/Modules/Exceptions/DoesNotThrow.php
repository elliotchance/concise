<?php

namespace Concise\Modules\Exceptions;

use Concise\Matcher\DidNotMatchException;

class DoesNotThrow extends Throws
{
    public function match($syntax, array $data = array())
    {
        try {
            $data[0]();

            return true;
        } catch (\Exception $exception) {
            if ($this->isKindOfClass($exception, $data[1])) {
                $exceptionClass = get_class($exception);
                throw new DidNotMatchException(
                    "Expected {$data[1]} not to be thrown, but $exceptionClass was thrown."
                );
            }
        }

        return true;
    }
}
