<?php

namespace Concise\Module;

use Concise\Core\DidNotMatchException;

class StringModule extends AbstractModule
{
    public function getName()
    {
        return "Strings";
    }

    /**
     * A string contains a substring. Returns original string.
     *
     * @return mixed
     * @throws DidNotMatchException
     * @syntax string ?:string contains ?:string
     */
    public function containsString()
    {
        if (strpos($this->data[0], $this->data[1]) === false) {
            throw new DidNotMatchException();
        }

        return $this->data[0];
    }

    /**
     * A string contains a substring (ignoring case-sensitivity). Returns
     * original string.
     *
     * @return mixed
     * @syntax string ?:string contains case insensitive ?:string
     */
    public function containsStringIgnoringCase()
    {
        $this->data = array(
            strtolower($this->data[0]),
            strtolower($this->data[1])
        );
        return $this->containsString();
    }

    /**
     * A string does not contain a substring. Returns original string.
     *
     * @return mixed
     * @throws DidNotMatchException
     * @syntax string ?:string does not contain ?:string
     */
    public function doesNotContainString()
    {
        if (strpos($this->data[0], $this->data[1]) !== false) {
            throw new DidNotMatchException();
        }

        return $this->data[0];
    }

    /**
     * A string does not contain a substring (ignoring case-sensitivity).
     * Returns original string.
     *
     * @return mixed
     * @syntax string ?:string does not contain case insensitive ?:string
     */
    public function doesNotContainStringIgnoringCase()
    {
        $this->data = array(
            strtolower($this->data[0]),
            strtolower($this->data[1])
        );
        return $this->doesNotContainString();
    }

    /**
     * Assert a string is zero length.
     *
     * @syntax string ?:string is empty
     */
    public function isBlank()
    {
        $this->failIf($this->data[0] !== '');
    }

    /**
     * Assert a string has at least one character.
     *
     * @return bool
     * @syntax string ?:string is not empty
     */
    public function isNotBlank()
    {
        $this->failIf($this->data[0] === '');
    }

    /**
     * Assert a string does not end with another string.
     *
     * @syntax string ? does not end with ?
     */
    public function doesNotEndWith()
    {
        $this->failIf($this->stringEndsWith());
    }

    /**
     * Assert a string does not not start (begin) with another string.
     *
     * @syntax string ? does not start with ?
     */
    public function doesNotStartWith()
    {
        $this->failIf($this->stringStartsWith());
    }

    /**
     * Assert a string ends with another string.
     *
     * @syntax string ?:string ends with ?:string
     */
    public function endsWith()
    {
        $this->failIf(!$this->stringEndsWith());
    }

    /**
     * Assert a string starts (begins) with another string.
     *
     * @syntax string ?:string starts with ?:string
     */
    public function startsWith()
    {
        $this->failIf(!$this->stringStartsWith());
    }

    /**
     * @return bool
     */
    protected function stringEndsWith()
    {
        return ((substr(
                $this->data[0],
                strlen($this->data[0]) - strlen($this->data[1])
            ) === $this->data[1]));
    }

    /**
     * @return bool
     */
    protected function stringStartsWIth()
    {
        return ((substr($this->data[0], 0, strlen($this->data[1])) ===
            $this->data[1]));
    }
}
