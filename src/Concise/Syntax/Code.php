<?php

namespace Concise\Syntax;

class Code
{
	protected $code;

	public function __construct($code)
	{
		$this->code = $code;
	}

	public function getCode()
	{
		return $this->code;
	}

	public function __toString()
	{
		return $this->getCode();
	}
}
