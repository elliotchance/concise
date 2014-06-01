<?php

namespace Concise\Services;

class SyntaxRenderer
{
	public function render($syntax, array $data = array())
	{
		$self = $this;
		return preg_replace_callback('/\?/', function($match) use(&$data, $self) {
    		$r = $self->renderValue(array_shift($data));
    		return $r;
		}, $syntax);
	}

	public function renderValue($value)
	{
		if(is_callable($value)) {
			return "function";
		}
		if(is_string($value)) {
			return "\"$value\"";
		}
		if(true === $value) {
			return 'true';
		}
		if(false === $value) {
			return 'false';
		}
		return $value;
	}
}
