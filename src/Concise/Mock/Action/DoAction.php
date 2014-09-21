<?php

namespace Concise\Mock\Action;

use Closure;

class DoAction extends AbstractCachingAction
{
    public function __construct(Closure $action)
    {
        parent::__construct($action);
    }

    /**
     * @return string
     */
    public function getActionCode()
    {
        return parent::getActionCode() . "return \$v();";
    }
}
