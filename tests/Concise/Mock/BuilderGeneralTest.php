<?php

namespace Concise\Mock;

/**
 * @group mocking
 */
class BuilderGeneralTest extends AbstractBuilderTestCase
{
    /**
     * @dataProvider allBuilders
     */
    public function testMockCanBeCreatedFromAnObjectThatExists(MockBuilder $builder)
    {
        $mock = $builder->get();
        $this->assert($mock, instance_of, $builder->getClassName());
    }

    /**
     * @dataProvider mockBuilders
     */
    public function testCallingMethodThatHasNoAssociatedActionWillThrowAnException(MockBuilder $builder, $type)
    {
        $this->expectFailure("myMethod() does not have an associated action - consider a niceMock()?");
        if ('mock interface' === $type) {
            $this->expectFailure("myMethod() is abstract and has no associated action.");
        }
        $mock = $builder->get();
        $mock->myMethod();
    }

    /**
     * @dataProvider niceMockBuilders
     */
    public function testCallingMethodThatHasNoAssociatedActionOnANiceMockWillUseOriginal(MockBuilder $builder, $type)
    {
        $mock = $builder->get();
        $this->assert($mock->myMethod(), equals, 'abc');
    }
}
