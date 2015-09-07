<?php

namespace Concise\Core;

use InvalidArgumentException;

class Syntax
{
    /**
     * @var string
     */
    protected $syntax;

    /**
     * @var string
     */
    protected $class = null;

    /**
     * @var string
     */
    protected $method = null;

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var bool
     */
    protected $nested;

    public function __construct($syntax, $method = null, $nested = false)
    {
        if ($method !== null) {
            if (strpos($method, '::') === false) {
                throw new InvalidArgumentException(
                    "Method must be in the form of class::method"
                );
            }
            list($this->class, $this->method) = explode("::", $method);
            if (!class_exists($this->class)) {
                throw new InvalidArgumentException(
                    "Class '$this->class' does not exist."
                );
            }
        }
        $this->syntax = $syntax;
        $this->nested = $nested;
    }

    /**
     * @return string
     */
    public function getSyntax()
    {
        return $this->syntax;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getRawSyntax()
    {
        return preg_replace('/\\?:[^\s$]+/i', '?', $this->syntax);
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return boolean
     */
    public function isNested()
    {
        return $this->nested;
    }

    public function getArgumentTypes()
    {
        $r = array();
        preg_replace_callback('/\\?:?([^\s$]+)/i', function ($v) use (&$r) {
                $r[] = explode(',', $v[1]);
            }, $this->syntax);
        return $r;
    }
}
