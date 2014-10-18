<?php

namespace Concise\Syntax;

use Exception;

class NoMatcherFoundException extends Exception
{
    protected $syntax;

    public function __construct($syntax = null)
    {
        parent::__construct("No such matcher for syntax '$syntax'.");
        $this->syntax = $syntax;
    }

    public function getSyntax()
    {
        return $this->syntax;
    }
}
