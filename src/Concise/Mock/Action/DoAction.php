<?php

namespace Concise\Mock\Action;

class DoAction extends AbstractAction
{
    protected $cacheKey;

    public function __construct(callable $action)
    {
        $this->cacheKey = md5(rand() . time());
    }

    public function getActionCode()
    {
        return "\$v = \Concise\Mock\Action\DoAction::\$cache['{$this->cacheKey}']; return \$v();";
    }
}
