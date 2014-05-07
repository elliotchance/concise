<?php

namespace Concise\Matcher;

abstract class AbstractMatcher
{
	const SUCCESS = null;

	public abstract function match($syntax, array $data = array());

	public abstract function matchesSyntax($syntax);
}
