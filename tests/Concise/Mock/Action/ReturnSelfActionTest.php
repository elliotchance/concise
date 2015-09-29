<?php

namespace Concise\Mock\Action;

use Concise\Core\TestCase;

class ReturnSelfActionTest extends TestCase
{
    public function testReturnSelfReturnsPHPCode()
    {
        $self = new ReturnSelfAction();
        /*$this->assert($self->getActionCode(), equals, 'return $this;');*/
        $this->assert($self->getActionCode())->equals('return $this;');
    }
}
