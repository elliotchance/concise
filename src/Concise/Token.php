<?php

namespace Concise;

class Token
{
	protected $type;

	protected $value;

	public function __construct($type, $value = null)
	{
		$this->type = $type;
		$this->value = $value;
	}

	public function getType()
	{
		return $this->type;
	}

	public function getValue()
	{
		return $this->value;
	}
}
