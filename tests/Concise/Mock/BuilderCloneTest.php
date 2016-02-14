<?php

namespace Concise\Mock;

/**
 * @group mocking
 * @group #76
 */
class BuilderCloneTest extends AbstractBuilderTestCase
{
    /**
     * @dataProvider allBuilders
     */
    public function testDisableCloneReturnsSelfForChaining(MockBuilder $builder)
    {
        $this->assert($builder->disableClone())->isTheSameAs($builder);
    }

    /**
     * @dataProvider allBuilders
     */
    public function testOriginalCloneCanBeDisabledOnMock(MockBuilder $builder)
    {
        $mock = $builder->disableClone()->get();
        $cloned = clone $mock;
        $this->assert($cloned)->isAnInstanceOf(get_class($mock));
    }

    /**
     * @dataProvider allBuilders
     */
    public function testOriginalCloneIsNotModifiedIsNotDisabled(
        MockBuilder $builder,
        $type
    ) {
        if (self::MOCK_INTERFACE !== $type) {
            $this->expectFailure('Did clone.');
        }

        $mock = $builder->get();
        $cloned = clone $mock;
        $this->assert($cloned)->isAnInstanceOf(get_class($mock));
    }
}
