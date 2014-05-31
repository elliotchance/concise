<?php

namespace Concise\Syntax;

class ConvertToString
{
	public function convertToString($value)
	{
		if(is_null($value) || is_bool($value) || is_resource($value)) {
			throw new \Exception("Cannot convert " . gettype($value) . " to string.");
		}
		if(is_callable($value)) {
			try {
				return $this->convertToString($value());
			}
			catch(\Exception $e) {
				return $e->getMessage();
			}
		}
		if(is_array($value)) {
			return json_encode($value);
		}
		return (string) $value;
	}
}
