<?php

namespace Concise\Mock\Action;

class AbstractCachingAction extends AbstractAction
{
    /**
     * @var array
     */
    public static $cache = array();

    /**
     * Each time a ReturnValueAction is instantiated it will generate a new
     * cache key.
     *
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

    /**
     * @return string
     */
    public function getActionCode()
    {
        return "\$v = \Concise\Mock\Action\AbstractCachingAction::\$cache['{$this->cacheKey}'];";
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return self::$cache[$this->cacheKey];
    }
}
