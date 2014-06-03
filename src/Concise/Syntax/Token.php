<?php

namespace Concise\Syntax;

class Token
{
	protected $value;

	public function __construct($value = null)
	{
		$this->value = $value;
	}

	public function getValue()
	{
		return $this->value;
	}

	public function __toString()
	{
		return $this->getValue();
	}
}
