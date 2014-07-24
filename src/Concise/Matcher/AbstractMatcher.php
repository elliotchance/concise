<?php

namespace Concise\Matcher;

use \Concise\Services\SyntaxRenderer;
use \Concise\Services\Comparer;

abstract class AbstractMatcher
{
	/**
	 * @param string $syntax
	 * @return bool
	 */
	public abstract function match($syntax, array $data = array());

	/**
	 * @return array Syntaxes this matcher can understand.
	 */
	public abstract function supportedSyntaxes();

	/**
	 * @param string $syntax
	 * @return string
	 */
	public function renderFailureMessage($syntax, array $data = array())
	{
		$renderer = new SyntaxRenderer();
		return $renderer->render($syntax, $data);
	}

	/**
	 * @return array
	 */
	public abstract function getTags();
}
