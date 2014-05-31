<?php

namespace Concise\Syntax;

class ConvertToString
{
	public function convertToString($value)
	{
		if($value === true) {
			throw new \Exception("Cannot convert boolean to string.");
		}
		return $value;
	}
}
