<?php

namespace Concise\Core;

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
            if ($this->startsWith($s1, $s2) || $this->startsWith($s2, $s1)) {
                throw new Exception("Syntax '$s1' conflicts with '$s2'.");
            }
        }
        $this->syntaxes[$syntax->getRawSyntax()] = $syntax;
    }

    /**
     * @param $s1
     * @param $s2
     * @return bool
     */
    protected function startsWith($s1, $s2)
    {
        return preg_match("/^" . preg_quote($s1) . "[^a-z]/", $s2);
    }
}
