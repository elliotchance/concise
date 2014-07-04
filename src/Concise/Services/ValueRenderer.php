<?php

namespace Concise\Services;

class ValueRenderer
{
	protected $context;

	public function setContext(array $context)
	{
		$this->context = $context;
	}

	public function render($value)
	{
		if(is_callable($value)) {
			return 'function';
		}
		if(is_object($value)) {
			if($value instanceof \Concise\Syntax\Token\Attribute) {
				return $this->render($this->context[$value->getValue()]);
			}
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
