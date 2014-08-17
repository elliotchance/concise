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

    public function testCanGeneratePHPCode()
    {
        $action = new DoAction(function () {});
        $this->assert($action->getActionCode(), matches_regex, "/return/");
    }

    public function testWillUseDifferentCacheKeyEachTime()
    {
        $action1 = new DoAction(function () {});
        $action2 = new DoAction(function () {});
        $this->assert($action1->getActionCode(), does_not_equal, $action2->getActionCode());
    }

    public function testItemCanBeFetchedBackFromCache()
    {
        $action = new DoAction(function () { return 'foo'; });
        $result = eval($action->getActionCode());
        $this->assert($result, equals, 'foo');
    }
}
