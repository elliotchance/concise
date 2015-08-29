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
        $syntax = new Syntax($string);
        if (array_key_exists($syntax->getRawSyntax(), $this->syntaxes)) {
            return $this->syntaxes[$syntax->getRawSyntax()];
        }
        throw new Exception("No such syntax '" . $syntax->getRawSyntax() . "'");
    }

    public function add(Syntax $syntax)
    {
        if (array_key_exists($syntax->getRawSyntax(), $this->syntaxes)) {
            throw new Exception("Syntax '" . $syntax->getSyntax() .
                "' already registered.");
        }
        foreach ($this->syntaxes as $s) {
            $s1 = $s->getRawSyntax();
            $s2 = $syntax->getRawSyntax();
            if (strlen($s1) < strlen($s2) && substr($s2, 0, strlen($s1)) == $s1) {
                throw new Exception("Syntax '$s1' conflicts with '$s2'.");
            }
        }
        $this->syntaxes[$syntax->getRawSyntax()] = $syntax;
    }
}
