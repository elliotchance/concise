<?php

namespace Concise\Mock;

/**
 * All mocks will implement this interface. It can be used to identity when
 * mocks are replacing real objects, and also provides the IDE with method
 * definitions that are added on to the mocked class.
 */
interface MockInterface
{
    /**
     * @param string $method
     * @return array
     */
    public function getCallsForMethod($method);
}
