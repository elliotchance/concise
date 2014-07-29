<?php

namespace Concise\Mock\Action;

class ReturnValueAction extends AbstractAction
{
	/**
	 * @var array
	 */
	public static $cache = array();

	/**
	 * Each time a ReturnValueAction is instantiated it will generate a new cache key.
	 * @var string
	 */
	protected $cacheKey;

	/**
	 * @param mixed $value
	 */
	public function __construct($value)
	{
		$this->cacheKey = md5(rand() . time());
		self::$cache[$this->cacheKey] = $value;
	}

	public function getActionCode()
	{
		return "\$v = \Concise\Mock\Action\ReturnValueAction::\$cache['{$this->cacheKey}']; return is_object(\$v) ? clone \$v : \$v;";
	}

	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return self::$cache[$this->cacheKey];
	}
}
