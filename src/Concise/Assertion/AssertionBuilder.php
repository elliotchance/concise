<?php

namespace Concise\Assertion;

class AssertionBuilder
{
    protected $syntax = '';

    public function __construct($value, $startingWord = null)
    {
        if (null !== $startingWord) {
            $this->syntax = "$startingWord ";
        }
        $this->syntax .= '?';
    }

    public function getData()
    {
        return array(123);
    }

    public function getSyntax()
    {
        return $this->syntax;
    }
}
