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
     * @expectedException \Exception
     * @expectedExceptionMessage myMethod() does not have an associated action - consider a niceMock()?
     * @dataProvider mockBuilders
     */
    public function testCallingMethodThatHasNoAssociatedActionWillThrowAnException(MockBuilder $builder, $type)
    {
        if ('mock interface' === $type) {
            $this->expectFailure('myMethod() is abstract and has no associated action.', '\Exception');
        }
        $mock = $builder->get();
        $mock->myMethod();
    }
}
