<?php

namespace Concise\Mock\Action;

class ReturnValueAction extends AbstractAction
{
	protected $value;

	public function __construct($value)
	{
		$this->value = $value;
	}

	public function getWillAction(\PHPUnit_Framework_TestCase $testCase)
	{
		return $testCase->returnValue($this->value);
	}
}
