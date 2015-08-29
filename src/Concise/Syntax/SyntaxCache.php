<?php

namespace Concise\Syntax;

use Concise\Matcher\Syntax;
use Exception;

class SyntaxCache
{
    /**
     * @var Syntax[]
     */
    protected $syntaxes = array();

    /**
     * @param $string
     * @throws Exception
     * @return Syntax
     */
    public function getSyntax($string)
    {
        if (array_key_exists($string, $this->syntaxes)) {
            return $this->syntaxes[$string];
        }
        throw new Exception("No such syntax '$string'");
    }

    public function add(Syntax $syntax)
    {
        if (array_key_exists($syntax->getSyntax(), $this->syntaxes)) {
            throw new Exception("Syntax '" . $syntax->getSyntax() .
                "' already registered.");
        }
        $this->syntaxes[$syntax->getSyntax()] = $syntax;
    }
}
