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
     * @syntax ?:string contains string ?:string
     * @nested
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
     * @syntax ?:string contains case insensitive string ?:string
     * @nested
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
     * @syntax ?:string does not contain string ?:string
     * @nested
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
     * @syntax ?:string does not contain case insensitive string ?:string
     * @nested
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
     * @return bool
     * @syntax ?:string is blank
     */
    public function isBlank()
    {
        return $this->data[0] === '';
    }

    /**
     * Assert a string has at least one character.
     *
     * @return bool
     * @syntax ?:string is not blank
     */
    public function isNotBlank()
    {
        return !$this->isBlank();
    }

    /**
     * Assert a string does not end with another string.
     *
     * @return bool
     * @syntax ? does not end with ?
     */
    public function doesNotEndWith()
    {
        return !$this->endsWith();
    }

    /**
     * Assert a string does not not start (begin) with another string.
     *
     * @return bool
     * @syntax ? does not start with ?
     */
    public function doesNotStartWith()
    {
        return !$this->startsWith();
    }

    /**
     * Assert a string ends with another string.
     *
     * @return bool
     * @syntax ?:string ends with ?:string
     */
    public function endsWith()
    {
        return ((substr(
                $this->data[0],
                strlen($this->data[0]) - strlen($this->data[1])
            ) ===
            $this->data[1]));
    }

    /**
     * Assert a string starts (begins) with another string.
     *
     * @return bool
     * @syntax ?:string starts with ?:string
     */
    public function startsWith()
    {
        return ((substr($this->data[0], 0, strlen($this->data[1])) ===
            $this->data[1]));
    }
}
