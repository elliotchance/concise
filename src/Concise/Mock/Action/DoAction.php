<?php

namespace Concise\Mock\Action;

class DoAction extends AbstractAction
{
    public function __construct(callable $action)
    {
        $this->cacheKey = '';
    }

    public function getActionCode()
    {
        return "\$v = \Concise\Mock\Action\DoAction::\$cache['{$this->cacheKey}']; return \$v();";
    }
}
