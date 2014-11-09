<?php

namespace Concise\Mock\Action;

abstract class AbstractAction
{
    /**
	 * @return string PHP code to be injected into the mocked method when building.
	 */
    abstract public function getActionCode();
}
