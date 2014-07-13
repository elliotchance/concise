<?php

namespace Concise\Mock\Action;

class ThrowAction extends AbstractAction
{
	public static $cache = array();

	protected $exception;

	public function __construct($exception)
	{
		$this->cacheId = md5(rand());
		self::$cache[$this->cacheId] = $exception;
	}

	public function getWillAction(\PHPUnit_Framework_TestCase $testCase)
	{
		return $testCase->throwException($this->exception);
	}

	public function getActionCode()
	{
		return 'throw \Concise\Mock\Action\ThrowAction::$cache["' . $this->cacheId . '"];';
	}
}
