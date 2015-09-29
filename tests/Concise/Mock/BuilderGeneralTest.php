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
    public function testMockCanBeCreatedFromAnObjectThatExists(
        MockBuilder $builder
    ) {
        $mock = $builder->get();
        $this->assert($mock)->isAnInstanceOf($builder->getClassName());
    }

    /**
     * @dataProvider mockBuilders
     */
    public function testCallingMethodThatHasNoAssociatedActionWillThrowAnException(
        MockBuilder $builder,
        $type
    ) {
        $this->expectFailure(
            "myMethod() does not have an associated action - consider a niceMock()?"
        );
        if (self::MOCK_INTERFACE === $type) {
            $this->expectFailure(
                "myMethod() is abstract and has no associated action."
            );
        }
        $mock = $builder->get();
        $mock->myMethod();
    }

    /**
     * @dataProvider niceMockBuilders
     */
    public function testCallingMethodThatHasNoAssociatedActionOnANiceMockWillUseOriginal(
        MockBuilder $builder
    ) {
        $mock = $builder->get();
        /*$this->assert($mock->myMethod(), equals, 'abc');*/
        $this->assert($mock->myMethod())->equals('abc');
    }

    /**
     * @dataProvider allBuilders
     */
    public function testMockImplementsMockInterface(MockBuilder $builder)
    {
        $mock = $builder->get();
        $this->assert($mock)->isAnInstanceOf('\Concise\Mock\MockInterface');
    }

    /**
     * @group #129
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage You cannot create a nice mock of an interface (\Concise\Mock\CombinationMockedInterface)
     */
    public function testCannotCreateANiceMockOfAnInterface()
    {
        $this->niceMock('\Concise\Mock\CombinationMockedInterface')->get();
    }
}
