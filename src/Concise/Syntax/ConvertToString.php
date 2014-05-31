<?php

namespace Concise\Syntax;

class ConvertToString
{
	public function convertToString($value)
	{
		if(is_bool($value)) {
			throw new \Exception("Cannot convert boolean to string.");
		}
		return $value;
	}
}
