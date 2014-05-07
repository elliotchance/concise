<?php

namespace Concise\Matcher;

abstract class AbstractMatcher
{
	const SUCCESS = null;

	public abstract function match($syntax, array $data = array());

	/**
	 * @return array of syntaxes this matcher can understand.
	 */
	public abstract function supportedSyntaxes();
}
