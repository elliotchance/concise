<?php

namespace Concise\Syntax;

use Concise\Matcher\Syntax;

class SyntaxCache
{
    protected $syntax;

    public function getSyntax($string)
    {
        if ($this->syntax) {
            return $this->syntax;
        }
        throw new \Exception("No such syntax '$string'");
    }

    public function add(Syntax $syntax)
    {
        $this->syntax = $syntax;
    }
}
