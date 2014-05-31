<?php

namespace Concise\Syntax;

class ConvertToString
{
	public function convertToString($value)
	{
		if(is_null($value) || is_bool($value)) {
			throw new \Exception("Cannot convert " . gettype($value) . " to string.");
		}
		if(is_callable($value)) {
			return $this->convertToString($value());
		}
		return (string) $value;
	}
}
