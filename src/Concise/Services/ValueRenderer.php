<?php

namespace Concise\Services;

class ValueRenderer
{
	/**
	 * @param  mixed $value
	 * @return string
	 */
	public function render($value)
	{
		if(is_callable($value)) {
			return 'function';
		}
		if(is_object($value)) {
			return get_class($value) . ':' . json_encode($value);
		}
		if(is_null($value) || is_array($value) || is_object($value) || is_bool($value)) {
			return json_encode($value);
		}
		if(is_string($value)) {
			return '"' . $value . '"';
		}
		return (string) $value;
	}
}
