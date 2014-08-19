<?php

namespace Concise\Mock;

use \Concise\TestCase;

interface MockInterface
{
}

class MockBuilderInterfaceTest extends TestCase
{
    public function testInterfacesAreAllowedToBeMocked()
    {
        $builder = $this->mock('\Concise\Mock\MockInterface');
        $this->assert($builder, is_not_null);
    }
}
