<?php

namespace Concise\Mock\Action;

class DoAction extends AbstractCachingAction
{
    public function __construct(\Closure $action)
    {
        parent::__construct($action);
    }

    public function getActionCode()
    {
        return parent::getActionCode() . "return \$v();";
    }
}
