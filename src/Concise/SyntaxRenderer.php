<?php

namespace Concise;

class SyntaxRenderer
{
	public function render($syntax, array $data = array())
	{
		return preg_replace_callback('/\?/', function($match) use(&$data) {
    		return array_shift($data);
		}, $syntax);
	}
}
