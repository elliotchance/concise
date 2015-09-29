<?php

namespace Concise\Mock\Action;

use Concise\Core\TestCase;

class ReturnPropertyActionTest extends TestCase
{
    public function testReturnPropertyReturnsPHPCode()
    {
        $self = new ReturnPropertyAction('foo');
        $this->assertString($self->getActionCode())
            ->contains('return $this->foo;');
    }
}
