<?php

namespace Concise\Mock\Action;

class ReturnPropertyAction extends AbstractAction
{
    protected $property;

    public function __construct($property)
    {
        $this->property = $property;
    }

    public function getActionCode()
    {
        return "return \$this->{$this->property};";
    }
}
