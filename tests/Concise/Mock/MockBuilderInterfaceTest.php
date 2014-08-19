<?php

namespace Concise\Mock;

use \Concise\TestCase;

interface MockInterface
{
    public function myMethod();
}

class MockBuilderInterfaceTest extends AbstractMockBuilderTestCase
{
    public function getClassName()
    {
        return '\Concise\Mock\MockInterface';
    }
}
