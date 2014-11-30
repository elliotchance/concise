<?php

namespace Concise\Mock;

use InvalidArgumentException;

class Invocation implements InvocationInterface
{
    /**
     * @var int
     */
    protected $invokedCount;

    /**
     * @var array
     */
    protected $arguments;

    /**
     * @param int $invokedCount
     */
    public function __construct($invokedCount = 1, array $arguments = array())
    {
        $this->invokedCount = $invokedCount;
        $this->arguments = $arguments;
    }

    /**
     * @return int
     */
    public function getInvokeCount()
    {
        return $this->invokedCount;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    public function getArgument($index)
    {
        if ($index < 0) {
            throw new InvalidArgumentException("Invalid argument index: $index");
        }
        return $this->arguments[$index];
    }
}
