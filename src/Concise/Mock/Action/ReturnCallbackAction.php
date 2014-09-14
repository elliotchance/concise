<?php

namespace Concise\Mock\Action;

use Closure;

class ReturnCallbackAction extends AbstractCachingAction
{
    /**
	 * @param Closure $callback
	 */
    public function __construct(Closure $callback)
    {
        parent::__construct($callback);
        self::$cache[$this->cacheKey . 'i'] = 1;
    }

    public function getActionCode()
    {
        return parent::getActionCode() . "return \$v(\Concise\Mock\Action\AbstractCachingAction::\$cache['{$this->cacheKey}i']++);";
    }
}
