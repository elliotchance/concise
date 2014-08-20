<?php

namespace Concise\Mock\Action;

use Concise\TestCase;

class ReturnValueActionTest extends TestCase
{
    public function testObjectReturnedInAnotherNamespaceIsCompatible()
    {
        $myObject = new \stdClass();
        $value = new ReturnValueAction(array($myObject));
        $result = eval($value->getActionCode());
        $this->assert($myObject, equals, $result);
    }

    public function testObjectsInCacheAreClonedSoThatTheyWillNotChangeState()
    {
        $myObject = json_decode('{"foo":"bar"}');
        $value = new ReturnValueAction(array($myObject));

        $result1 = eval($value->getActionCode());
        $result1->foo = "baz";
        $result2 = eval($value->getActionCode());

        $this->assert($result2->foo, equals, "bar");
    }
}
