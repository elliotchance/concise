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
     * @param int   $invokedCount
     * @param array $arguments
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

    /**
     * @param int $index
     * @return mixed
     */
    public function getArgument($index)
    {
        $count = $this->getArgumentCount();
        if ($index < 0 || $index >= $count) {
            $message = "Invalid argument index: $index (only $count arguments)";
            throw new InvalidArgumentException($message);
        }
        return $this->arguments[$index];
    }

    /**
     * @return int
     */
    public function getArgumentCount()
    {
        return count($this->arguments);
    }
}
