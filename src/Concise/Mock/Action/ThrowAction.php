<?php

namespace Concise\Mock\Action;

use Exception;

class ThrowAction extends AbstractCachingAction
{
    public function __construct(Exception $e)
    {
        parent::__construct($e);
    }

    /**
     * @return string
     */
    public function getActionCode()
    {
        return parent::getActionCode() . 'throw $v;';
    }
}
