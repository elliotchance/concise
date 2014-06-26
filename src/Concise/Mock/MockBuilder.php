<?php

namespace Concise\Mock;

class MockBuilder
{
	/** @var \PHPUnit_Framework_TestCase */
	protected $testCase;

	public function __construct(\PHPUnit_Framework_TestCase $testCase, $className)
	{
		$this->testCase = $testCase;
		if(!class_exists($className)) {
			throw new \Exception("Class '$className' does not exist.");
		}
		$this->className = $className;
	}

	public function getMock()
	{
		return $this->testCase->getMock($this->className);
	}
}
