<?php

namespace Concise\Module;

/**
 * Regular Expressions
 */
class RegularExpressionModule extends AbstractModule
{
    public function getName()
    {
        return "Regular Expressions";
    }

    /**
     * Assert that a string matches a regular expression.
     *
     * @syntax string ?:string matches ?:regex
     */
    public function matchesRegex()
    {
        $this->failIf(preg_match($this->data[1], $this->data[0]) !== 1);
    }

    /**
     * Assert that a string does not match a regular expression.
     *
     * @syntax string ?:string does not match ?:regex
     */
    public function doesNotMatchRegex()
    {
        $this->failIf(preg_match($this->data[1], $this->data[0]) === 1);
    }
}
