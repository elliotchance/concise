<?php

namespace Concise\Syntax;

use Concise\Matcher\Syntax;

class SyntaxCache
{
    /**
     * @var Syntax[]
     */
    protected $syntaxes = array();

    /**
     * @param $string
     * @throws \Exception
     * @return Syntax
     */
    public function getSyntax($string)
    {
        if (array_key_exists($string, $this->syntaxes)) {
            return $this->syntaxes[$string];
        }
        throw new \Exception("No such syntax '$string'");
    }

    public function add(Syntax $syntax)
    {
        $this->syntaxes[$syntax->getSyntax()] = $syntax;
    }
}
