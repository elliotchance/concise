<?php

namespace Concise;

class Token
{
	protected $type;

	public function __construct($type)
	{
		$this->type = $type;
	}

	public function getType()
	{
		return $this->type;
	}

	public function getValue()
	{
		return null;
	}
}
