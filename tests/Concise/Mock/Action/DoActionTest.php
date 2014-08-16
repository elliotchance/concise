<?php

namespace Concise\Mock\Action;

use Concise\TestCase;

class DoActionTest extends TestCase
{
    public function testMustBeATypeOfAction()
    {
        $action = new DoAction(function () {});
        $this->assert($action, instance_of, '\Concise\Mock\Action\AbstractAction');
    }
}
