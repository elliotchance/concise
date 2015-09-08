<?php

namespace Concise\Mock\Action;

use Concise\TestCase;

class ReturnSelfActionTest extends TestCase
{
    public function testReturnSelfReturnsPHPCode()
    {
        $self = new ReturnSelfAction();
        /*$this->assert($self->getActionCode(), equals, 'return $this;');*/
        $this->aassert($self->getActionCode())->equals('return $this;');
    }
}
