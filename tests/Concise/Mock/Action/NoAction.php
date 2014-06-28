<?php

namespace Concise\Mock\Action;

class NoAction extends AbstractAction
{
	public function getWillAction(\PHPUnit_Framework_TestCase $testCase)
	{
		return null;
	}
}
