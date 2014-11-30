<?php

namespace Concise\Mock;

class Invocation implements InvocationInterface
{
    /**
     * @return int
     */
    public function getInvokeCount()
    {
        return 1;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return array();
    }
}
