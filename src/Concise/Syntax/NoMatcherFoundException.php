<?php

namespace Concise\Syntax;

use Exception;

class NoMatcherFoundException extends Exception
{
    public function getSyntax()
    {
        return null;
    }
}
