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
     * @syntax string ?:string matches ?:regex
     */
    public function matchesRegex()
    {
        $this->failIf(preg_match($this->data[1], $this->data[0]) !== 1);
    }

    /**
     * @syntax string ?:string does not match ?:regex
     */
    public function doesNotMatchRegex()
    {
        $this->failIf(preg_match($this->data[1], $this->data[0]) === 1);
    }
}
