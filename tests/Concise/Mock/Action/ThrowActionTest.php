<?php

namespace Concise\Mock\Action;

use Concise\TestCase;

class ThrowActionTest extends TestCase
{
    /**
     * @expectedException \Exception
     * @expectedExceptionMessage must be an instance of Exception
     */
    public function testConstructorWillOnlyAcceptAnException()
    {
        new ThrowAction('foo');
    }
}
