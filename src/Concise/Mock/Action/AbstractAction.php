<?php

namespace Concise\Mock\Action;

abstract class AbstractAction
{
	public abstract function getWillAction(\PHPUnit_Framework_TestCase $testCase);

	public abstract function getActionCode();
}
