<?php

namespace Concise\Mock\Action;

class DoAction extends AbstractCachingAction
{
    public function getActionCode()
    {
        return parent::getActionCode() . "return \$v();";
    }
}
