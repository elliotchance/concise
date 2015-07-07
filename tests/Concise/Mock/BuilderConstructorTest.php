<?php

namespace Concise\Mock;

/**
 * @group mocking
 */
class BuilderConstructorTest extends AbstractBuilderTestCase
{
    /**
     * @dataProvider allBuilders
     */
    public function testMocksCanHaveTheirConstructorDisabled(
        MockBuilder $builder,
        $type
    ) {
        if (self::MOCK_INTERFACE === $type) {
            $this->expectFailure(
                'You cannot disable the constructor of an interface (\Concise\Mock\CombinationMockedInterface).'
            );
        } elseif (self::MOCK_PARTIAL === $type) {
            $this->expectFailure(
                'You cannot disable the constructor on a partial mock because any constructor would have already run (Concise\Mock\CombinationMockClass).'
            );
        }
        $mock = $builder->disableConstructor()->get();
        $this->assert($mock->constructorRun, is_false);
    }

    /**
     * @dataProvider allBuilders
     */
    public function testMockReceivesConstructorArguments(
        MockBuilder $builder,
        $type
    ) {
        if (self::MOCK_INTERFACE === $type) {
            return $this->notApplicable();
        }
        $mock = $builder->get();
        $this->assert($mock->constructorRun, equals, 2);
    }
}
