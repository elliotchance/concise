<?php

namespace Concise\Mock\Action;

class ThrowAction extends AbstractCachingAction
{
    public function __construct(\Exception $e)
    {
        parent::__construct($e);
    }

    public function getActionCode()
    {
        return parent::getActionCode() . 'throw $v;';
    }
}
