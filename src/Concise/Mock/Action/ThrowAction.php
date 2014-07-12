<?php

namespace Concise\Mock\Action;

class ThrowAction extends AbstractAction
{
	protected $exception;

	public function __construct($exception)
	{
		$this->exception = $exception;
	}

	public function getWillAction(\PHPUnit_Framework_TestCase $testCase)
	{
		return $testCase->throwException($this->exception);
	}

	public function getActionCode()
	{
		var_dump('throw unserialize("' . serialize($this->exception) . '");');
		return 'throw unserialize("' . serialize($this->exception) . '");';
	}
}
