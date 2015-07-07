<?php

namespace Concise\Mock\Action;

use Concise\TestCase;

class ReturnPropertyActionTest extends TestCase
{
    public function testReturnPropertyReturnsPHPCode()
    {
        $self = new ReturnPropertyAction('foo');
        $this->assert(
            $self->getActionCode(),
            contains_string,
            'return $this->foo;'
        );
    }
}
