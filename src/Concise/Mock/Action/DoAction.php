<?php

namespace Concise\Mock\Action;

class DoAction extends AbstractAction
{
    public function __construct(callable $action)
    {
    }

    public function getActionCode()
    {
        return '';
    }
}
