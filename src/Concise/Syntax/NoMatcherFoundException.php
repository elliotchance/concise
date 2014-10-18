<?php

namespace Concise\Syntax;

use Exception;

class NoMatcherFoundException extends Exception
{
    protected $syntax;

    public function __construct($syntax = null)
    {
        $this->syntax = $syntax;
    }

    public function getSyntax()
    {
        return $this->syntax;
    }
}
