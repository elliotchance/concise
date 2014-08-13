<?php

namespace Concise\Mock\Action;

abstract class AbstractAction
{
    /**
	 * @return string PHP code to be injected into the mocked method when builing.
	 */
    abstract public function getActionCode();
}
