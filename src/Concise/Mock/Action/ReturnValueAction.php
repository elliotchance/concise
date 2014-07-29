<?php

namespace Concise\Mock\Action;

class ReturnValueAction extends AbstractAction
{
	public static $cache = array();

	protected $cacheKey;

	public function __construct($value)
	{
		$this->cacheKey = md5(rand() . time());
		self::$cache[$this->cacheKey] = $value;
	}

	public function getActionCode()
	{
		return "\$v = \Concise\Mock\Action\ReturnValueAction::\$cache['{$this->cacheKey}']; return is_object(\$v) ? clone \$v : \$v;";
	}

	public function getValue()
	{
		return self::$cache[$this->cacheKey];
	}
}
