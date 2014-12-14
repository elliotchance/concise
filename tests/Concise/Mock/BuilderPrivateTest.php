<?php

namespace Concise\Mock;

/**
 * @group mocking
 */
class BuilderPrivateTest extends AbstractBuilderTestCase
{
    /**
     * @expectedException \Exception
     * @expectedExceptionMessage cannot be mocked because it it private.
     * @dataProvider allBuilders
     */
    public function testMockingPrivateMethodWillThrowException(MockBuilder $builder, $type)
    {
        if (self::MOCK_INTERFACE === $type) {
            $this->expectFailure('does not exist.');
        }
        $builder->stub(array('myPrivateMethod' => 'bar'))
            ->get();
    }
}
