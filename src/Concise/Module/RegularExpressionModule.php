<?php

namespace Concise\Module;

use Concise\Matcher\AbstractMatcher;

/**
 * Regular Expressions
 */
class RegularExpressionModule extends AbstractMatcher
{
    /**
     * @syntax ?:string matches regular expression ?:regex
     * @syntax ?:string matches regex ?:regex
     */
    public function matchesRegex()
    {
        return preg_match($this->data[1], $this->data[0]) === 1;
    }

    /**
     * @syntax ?:string does not match regular expression ?:regex
     * @syntax ?:string doesnt match regular expression ?:regex
     * @syntax ?:string does not match regex ?:regex
     * @syntax ?:string doesnt match regex ?:regex
     */
    public function doesNotMatchRegex()
    {
        return !$this->matchesRegex();
    }
}
