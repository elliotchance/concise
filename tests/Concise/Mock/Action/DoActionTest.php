<?php

namespace Concise\Mock\Action;

use Concise\Core\TestCase;

class DoActionTest extends TestCase
{
    public function testMustBeATypeOfAction()
    {
        $action = new DoAction(
            function () {
            }
        );
        /*$this->assert(
            $action,
            instance_of,
            '\Concise\Mock\Action\AbstractAction'
        );*/
        $this->assert($action)->instanceOf('\Concise\Mock\Action\AbstractAction');
    }

    public function testCanGeneratePHPCode()
    {
        $action = new DoAction(
            function () {
            }
        );
        /*$this->assert($action->getActionCode(), matches_regex, "/return/");*/
        $this->assert($action->getActionCode())->matchesRegex("/return/");
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
        $this->assert($action1->getActionCode())
            ->doesNotEqual($action2->getActionCode());
    }
}
