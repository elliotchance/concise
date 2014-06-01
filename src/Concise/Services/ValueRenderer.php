<?php

namespace Concise\Services;

class ValueRenderer
{
	public function render($value)
	{
		if(is_null($value) || is_array($value) || is_object($value) || is_bool($value)) {
			return json_encode($value);
		}
		if(is_string($value)) {
			return '"' . $value . '"';
		}
		return (string) $value;
	}
}
