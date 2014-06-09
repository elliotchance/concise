<?php

namespace Concise\Syntax\Token;

use Concise\Syntax\Token;

class Attribute extends Token
{
	protected $acceptedTypes = array();

	public function __construct($value)
	{
		parent::__construct($value);
		$pos = strpos($value, ':');
		if($pos !== false) {
			$this->acceptedTypes = explode(',', substr($value, $pos + 1));
			$this->value = '?';
		}
	}

	public function getAcceptedTypes()
	{
		return $this->acceptedTypes;
	}
}
