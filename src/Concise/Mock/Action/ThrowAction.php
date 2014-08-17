<?php

namespace Concise\Mock\Action;

class ThrowAction extends AbstractCachingAction
{
    public function getActionCode()
    {
        return parent::getActionCode() . 'throw $v;';
    }
}
