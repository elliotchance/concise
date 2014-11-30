<?php

namespace Concise\Mock;

interface InvocationInterface
{
    /**
     * Get the index of the invocation (how many times it has been called up until now) starting at
     * 1.
     * @return int
     */
    public function getInvokeCount();

    /**
     * Get the original arguments passed with the invocation.
     * @return array
     */
    public function getArguments();

    /**
     * @return int
     */
    public function getArgumentCount();
}
