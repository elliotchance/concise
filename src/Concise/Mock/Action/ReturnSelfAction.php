<?php

namespace Concise\Mock\Action;

class ReturnSelfAction extends AbstractAction
{
    public function getActionCode()
    {
        return 'return $this;';
    }
}
