<?php

namespace Concise\Matcher;

abstract class AbstractMatcher
{
	public abstract function match(array $data = array());
}
