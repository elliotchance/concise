<?php

namespace Concise\Mock\Action;

use Concise\TestCase;

class DoActionTest extends TestCase
{
    public function testMustBeATypeOfAction()
    {
        $action = new DoAction(
            function () {
            }
        );
        $this->assert(
            $action,
            instance_of,
            '\Concise\Mock\Action\AbstractAction'
        );
    }

    public function testCanGeneratePHPCode()
    {
        $action = new DoAction(
            function () {
            }
        );
        $this->assert($action->getActionCode(), matches_regex, "/return/");
    }

    public function testWillUseDifferentCacheKeyEachTime()
    {
        $action1 = new DoAction(
            function () {
            }
        );
        $action2 = new DoAction(
            function () {
            }
        );
        $this->aassert($action1->getActionCode())
            ->doesNotEqual($action2->getActionCode());
    }
}
