<?php

namespace Concise\Syntax;

class Token
{
	/**
	 * @var mixed
	 */
	protected $value;

	/**
	 * @param mixed $value
	 */
	public function __construct($value = null)
	{
		$this->value = $value;
	}

	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->getValue();
	}
}
