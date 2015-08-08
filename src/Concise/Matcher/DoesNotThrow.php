<?php

namespace Concise\Matcher;

use Concise\Modules\Exceptions\Throws;

class DoesNotThrow extends Throws
{
    public function supportedSyntaxes()
    {
        return array(
            '?:callable does not throw ?:class' => "Assert that a specific exception is not thrown.",
        );
    }

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
