<?php

namespace Concise\Services;

class ValueRenderer
{
	public function render($value)
	{
		if(true === $value) {
			return 'true';
		}
		if(is_array($value) || is_object($value)) {
			return json_encode($value);
		}
		if(is_string($value)) {
			return '"' . $value . '"';
		}
		return (string) $value;
	}
}
