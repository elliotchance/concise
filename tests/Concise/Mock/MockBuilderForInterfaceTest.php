<?php

namespace Concise\Mock;

interface MockedInterface
{
    public function myMethod();

    public function mySecondMethod();

    public static function myStaticMethod();

    public function myWithMethod($a);

    public function myAbstractMethod();
}

/**
 * @group mocking
 */
class MockBuilderForInterfaceTest extends AbstractMockBuilderTestCase
{
    public function getClassName()
    {
        return '\Concise\Mock\MockedInterface';
    }

    public function testMockAbstractClassesThatDoNotHaveRulesForAllMethodsWillStillOperate()
    {
        $this->notApplicable();
    }

    public function testFinalMethodsCanNotBeMocked()
    {
        $this->notApplicable();
    }
}
