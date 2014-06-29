<?php

namespace Concise\Mock\Action;

class NoAction extends AbstractAction
{
	public function getWillAction(\PHPUnit_Framework_TestCase $testCase)
	{
		throw new \Exception("You cannot render an action from NoAction.");
	}
}
