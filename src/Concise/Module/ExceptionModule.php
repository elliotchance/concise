<?php

namespace Concise\Module;

use Concise\Core\DidNotMatchException;
use Exception;

class ExceptionModule extends AbstractModule
{
    public function getName()
    {
        return "Exceptions";
    }

    /**
     * Assert that a specific exception is not thrown.
     *
     * @syntax closure ?:callable does not throw ?:class
     * @throws DidNotMatchException
     */
    public function doesNotThrow()
    {
        try {
            $this->data[0]();
        } catch (Exception $exception) {
            if ($this->isKindOfClass($exception, $this->data[1])) {
                $exceptionClass = get_class($exception);
                throw new DidNotMatchException(
                    "Expected {$this->data[1]} not to be thrown, " .
                    "but $exceptionClass was thrown."
                );
            }
        }
    }

    /**
     * Assert that no exception is thrown.
     *
     * @syntax closure ?:callable does not throw exception
     * @throws DidNotMatchException
     */
    public function doesNotThrowException()
    {
        try {
            $this->data[0]();
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
     * @syntax closure ?:callable throws ?:class
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
     * @syntax closure ?:callable throws anything except ?:class
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
        }
    }

    /**
     * Assert a specific exception was thrown.
     *
     * @syntax closure ?:callable throws exactly ?:class
     * @throws DidNotMatchException
     */
    public function throwsExactly()
    {
        try {
            $this->data[0]();
        } catch (Exception $exception) {
            $exceptionClass = get_class($exception);
            if ($exceptionClass === $this->data[1]) {
                return;
            } else {
                throw new DidNotMatchException(
                    "Expected exactly {$this->data[1]} to be thrown, " .
                    "but $exceptionClass was thrown."
                );
            }
        }
        throw new DidNotMatchException(
            "Expected exactly {$this->data[1]} to be thrown, " .
            "but nothing was thrown."
        );
    }

    /**
     * Assert an exception was thrown.
     *
     * @syntax closure ?:callable throws exception
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
