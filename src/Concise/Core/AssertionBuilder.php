<?php

namespace Concise\Core;

class AssertionBuilder
{
    protected $data = array();

    protected $syntax = '';

    public function __call($words, $args)
    {
        if (null !== $words) {
            $this->syntax .=
                strtolower(preg_replace('/([A-Z])/', ' $1', $words)) .
                ' ';
        }

        if (count($args) > 0) {
            $this->data[] = $args[0];
            $this->syntax .= '? ';
        }

        return $this;
    }

    public function __get($name)
    {
        return $this->__call($name, array());
    }

    public function getData()
    {
        return $this->data;
    }

    public function getSyntax()
    {
        return rtrim($this->syntax);
    }

    public function _($value)
    {
        return $this->__call(null, array($value));
    }
}
