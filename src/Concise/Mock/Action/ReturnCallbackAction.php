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
    }

    public function getActionCode()
    {
        return parent::getActionCode() . "return \$v(1);";
    }
}
