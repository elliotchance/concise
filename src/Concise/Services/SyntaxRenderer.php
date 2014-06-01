<?php

namespace Concise\Services;

class SyntaxRenderer
{
	public function render($syntax, array $data = array())
	{
		$renderer = new ValueRenderer();
		return preg_replace_callback('/\?/', function($match) use(&$data, $renderer) {
    		$r = $renderer->render(array_shift($data));
    		return $r;
		}, $syntax);
	}
}
