<?php

namespace Concise\Services;

class ValueRenderer
{
	public function render($value)
	{
		if(is_string($value)) {
			return '"' . $value . '"';
		}
		return (string) $value;
	}
}
