<?php

namespace Concise\Matcher;

abstract class AbstractMatcher
{
	const SUCCESS = null;

	public abstract function match(array $data = array());
}
