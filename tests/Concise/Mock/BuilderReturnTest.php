<?php

namespace Concise\Mock;

/**
 * @group mocking
 */
class BuilderReturnTest extends AbstractBuilderTestCase
{
    /**
     * @dataProvider allBuilders
     */
    public function testAndReturnWithASingleArgument(MockBuilder $builder)
    {
        $mock = $builder->stub('myMethod')->andReturn('foo')->get();
        /*$this->assert($mock->myMethod(), equals, 'foo');*/
        $this->aassert($mock->myMethod())->equals('foo');
    }

    /**
     * @dataProvider allBuilders
     */
    public function testAndReturnCanTakeMultipleArguments(MockBuilder $builder)
    {
        $mock = $builder->stub('myMethod')->andReturn('foo', 'bar')->get();
        /*$this->assert($mock->myMethod(), equals, 'foo');*/
        $this->aassert($mock->myMethod())->equals('foo');
    }

    /**
     * @dataProvider allBuilders
     */
    public function testAndReturnWithMultipleArgumentsCanBeCalledWithDifferentResults(
        MockBuilder $builder
    ) {
        $mock = $builder->stub('myMethod')->andReturn('foo', 'bar')->get();
        $mock->myMethod();
        /*$this->assert($mock->myMethod(), equals, 'bar');*/
        $this->aassert($mock->myMethod())->equals('bar');
    }

    /**
     * @dataProvider allBuilders
     */
    public function testAndReturnWithASingleArgumentWillAlwaysReturnThatValue(
        MockBuilder $builder
    ) {
        $mock = $builder->stub('myMethod')->andReturn('foo')->get();
        $mock->myMethod();
        $mock->myMethod();
        /*$this->assert($mock->myMethod(), equals, 'foo');*/
        $this->aassert($mock->myMethod())->equals('foo');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Only 2 return values have been provided.
     * @dataProvider allBuilders
     */
    public function testAndReturnWithMultipleArgumentsCanNotBeCalledMoreTimesThatReturnValues(
        MockBuilder $builder
    ) {
        $mock = $builder->stub('myMethod')->andReturn('foo', 'bar')->get();
        $mock->myMethod();
        $mock->myMethod();
        $mock->myMethod();
    }
}
