<?php

namespace Concise\Mock;

class Invocation implements InvocationInterface
{
    /**
     * @var int
     */
    protected $invokedCount;

    /**
     * @param int $invokedCount
     */
    public function __construct($invokedCount = 1)
    {
        $this->invokedCount = $invokedCount;
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
        return array();
    }
}
