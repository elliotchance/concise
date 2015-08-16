<?php

namespace Concise\Module;

use Concise\Matcher\AbstractMatcher;
use Concise\Matcher\DidNotMatchException;
use Exception;

class ExceptionModule extends AbstractMatcher
{
    /**
     * Assert that a specific exception is not thrown.
     *
     * @syntax ?:callable does not throw ?:class
     * @return bool
     * @throws DidNotMatchException
     */
    public function doesNotThrow()
    {
        try {
            $this->data[0]();

            return true;
        } catch (Exception $exception) {
            if ($this->isKindOfClass($exception, $this->data[1])) {
                $exceptionClass = get_class($exception);
                throw new DidNotMatchException(
                    "Expected {$this->data[1]} not to be thrown, " .
                    "but $exceptionClass was thrown."
                );
            }
        }

        return true;
    }

    /**
     * Assert that no exception is thrown.
     *
     * @syntax ?:callable does not throw exception
     * @throws DidNotMatchException
     */
    public function doesNotThrowException()
    {
        try {
            $this->data[0]();

            return true;
        } catch (Exception $exception) {
            throw new DidNotMatchException(
                "Expected exception not to be thrown."
            );
        }
    }

    protected function isKindOfClass(Exception $exception, $expectedClass)
    {
        return (get_class($exception) === $expectedClass) ||
        is_subclass_of($exception, $expectedClass);
    }

    /**
     * Assert a specific exception was thrown.
     *
     * @syntax ?:callable throws ?:class
     * @throws DidNotMatchException
     */
    public function throws()
    {
        try {
            $this->data[0]();
        } catch (Exception $exception) {
            if ($this->isKindOfClass($exception, $this->data[1])) {
                return true;
            }
            $exceptionClass = get_class($exception);
            throw new DidNotMatchException(
                "Expected {$this->data[1]} to be thrown, " .
                "but $exceptionClass was thrown."
            );
        }
        throw new DidNotMatchException(
            "Expected {$this->data[1]} to be thrown, but nothing was thrown."
        );
    }

    /**
     * Assert any exception except a specific one was thrown.
     *
     * @syntax ?:callable throws anything except ?:class
     * @return bool
     * @throws DidNotMatchException
     */
    public function throwsAnythingExcept()
    {
        try {
            $this->data[0]();
        } catch (Exception $exception) {
            $exceptionClass = get_class($exception);
            if ($exceptionClass === $this->data[1]) {
                throw new DidNotMatchException(
                    "Expected any exception except {$this->data[1]} to be " .
                    "thrown, but $exceptionClass was thrown."
                );
            }

            return false;
        }

        return true;
    }

    /**
     * Assert a specific exception was thrown.
     *
     * @syntax ?:callable throws exactly ?:class
     * @throws DidNotMatchException
     */
    public function throwsExactly()
    {
        try {
            $this->data[0]();
        } catch (Exception $exception) {
            $exceptionClass = get_class($exception);
            if ($exceptionClass !== $this->data[1]) {
                throw new DidNotMatchException(
                    "Expected exactly {$this->data[1]} to be thrown, " .
                    "but $exceptionClass was thrown."
                );
            }

            return true;
        }
        throw new DidNotMatchException(
            "Expected exactly {$this->data[1]} to be thrown, " .
            "but nothing was thrown."
        );
    }

    /**
     * Assert an exception was thrown.
     *
     * @syntax ?:callable throws exception
     * @return bool
     * @throws DidNotMatchException
     */
    public function throwsException()
    {
        try {
            $this->data[0]();
        } catch (Exception $exception) {
            return true;
        }
        throw new DidNotMatchException("Expected exception to be thrown.");
    }
}
