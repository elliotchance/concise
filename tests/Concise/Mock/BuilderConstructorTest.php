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
    public function testMocksCanHaveTheirConstructorDisabled(MockBuilder $builder, $type)
    {
        if ('mock interface' === $type) {
            $this->expectFailure('You cannot disable the constructor of an interface (\Concise\Mock\CombinationMockedInterface).');
        } elseif ('partial' === $type) {
            $this->expectFailure('You cannot disable the constructor on a partial mock because any constructor would have already run (Concise\Mock\CombinationMockClass).');
        }
        $mock = $builder->disableConstructor()->get();
        $this->assert($mock->constructorRun, is_false);
    }

    /**
     * @dataProvider allBuilders
     */
    public function testMockReceivesConstructorArguments(MockBuilder $builder, $type)
    {
        if ('mock interface' === $type) {
            return $this->notApplicable();
        }
        $mock = $builder->get();
        $this->assert($mock->constructorRun, equals, 2);
    }
}
