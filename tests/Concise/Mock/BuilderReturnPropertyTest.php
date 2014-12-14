<?php

namespace Concise\Mock;

/**
 * @group mocking
 */
class BuilderReturnPropertyTest extends AbstractBuilderTestCase
{
    /**
     * @dataProvider allBuilders
     */
    public function testAReturnPropertyCanBeSet(MockBuilder $builder, $type)
    {
        if (self::MOCK_INTERFACE === $type) {
            $this->expectFailure("You cannot return a property from an interface (\Concise\Mock\CombinationMockedInterface).");
        }
        $mock = $builder->stub('myMethod')->andReturnProperty('hidden')->get();
        $this->assert($mock->myMethod(), equals, 'foo');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Property 'doesnt_exist' does not exist for
     * @dataProvider allBuilders
     */
    public function testAnExceptionIsThrownIfPropertyDoesNotExistAtRuntime(MockBuilder $builder, $type)
    {
        if (self::MOCK_INTERFACE === $type) {
            $this->expectFailure("You cannot return a property from an interface (\Concise\Mock\CombinationMockedInterface).");
        }
        $mock = $builder->stub('myMethod')->andReturnProperty('doesnt_exist')->get();
        $mock->myMethod();
    }
}
