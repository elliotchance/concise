<?php

namespace Concise\Mock\Action;

class ReturnSelfAction extends AbstractAction
{
    /**
	 * @return string
	 */
    public function getActionCode()
    {
        return 'return $this;';
    }
}
