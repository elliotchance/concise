<?php

namespace Concise\Mock\Action;

class ReturnValueAction extends AbstractAction
{
	/**
	 * @var mixed
	 */
	protected $value;

	/**
	 * @param mixed $value
	 */
	public function __construct($value)
	{
		$this->value = $value;
	}

	public function getActionCode()
	{
		return 'return ' . var_export($this->value, true) . ';';
	}

	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}
}
