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
            if ($this->isSubSyntax($s1, $s2) || $this->isSubSyntax($s2, $s1)) {
                throw new Exception("Syntax '$s1' conflicts with '$s2'.");
            }
        }
        $this->syntaxes[$syntax->getRawSyntax()] = $syntax;
    }

    /**
     * @param string $s1
     * @param string $s2
     * @return bool
     */
    protected function isSubSyntax($s1, $s2)
    {
        // We can't simply compare strings because it would cause a
        // false-positive with "? foo" and "? foobar" conflicting. Instead we
        // treat whole words (splitting on the space) as characters with the
        // same logic as a string-starts-with algorithm.
        $s1p = explode(' ', $s1);
        $s2p = explode(' ', $s2);
        $count = count($s1p);

        return array_slice($s1p, 0, $count) == array_slice($s2p, 0, $count);
    }
}
