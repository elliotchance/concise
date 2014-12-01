<?php

namespace Concise\Mock\Action;

use Closure;

class DoAction extends AbstractCachingAction
{
    public function __construct(Closure $action)
    {
        parent::__construct($action);
        self::$cache[$this->cacheKey . 'i'] = 1;
    }

    /**
     * @return string
     */
    public function getActionCode()
    {
        return parent::getActionCode() . "return \$v(new \Concise\Mock\Invocation(\Concise\Mock\Action\AbstractCachingAction::\$cache['{$this->cacheKey}i']++, func_get_args()));";
    }
}
