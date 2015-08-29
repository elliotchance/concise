<?php

namespace Concise\Syntax;

class SyntaxCache
{
    public function getSyntax($string)
    {
        throw new \Exception("No such syntax '$string'");
    }
}
