<?php

namespace Concise\Assertion;

class AssertionBuilder
{
    protected $data = array();

    protected $syntax = '';

    public function add($word = null, $value = null)
    {
        if (null !== $word) {
            $this->syntax .= "$word ";
        }

        if (null !== $value) {
            $this->data[] = $value;
            $this->syntax .= '? ';
        }
    }

    public function getData()
    {
        return $this->data;
    }

    public function getSyntax()
    {
        return rtrim($this->syntax);
    }
}
