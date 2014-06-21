<?php

namespace Concise\Services;

class SyntaxRenderer
{
	/**
	 * @param string $syntax
	 */
	public function render($syntax, array $data = array())
	{
		$renderer = new ValueRenderer();
		return preg_replace_callback('/\?/', function() use(&$data, $renderer) {
    		$r = $renderer->render(array_shift($data));
    		return $r;
		}, $syntax);
	}
}
