<?php

namespace Concise\Mock;

/**
 * @group mocking
 */
class BuilderExposeTest extends AbstractBuilderTestCase
{
    protected function youCannotExposeAMethodOnAMockThatIsNotNice($type)
    {
        switch ($type) {
            case self::MOCK_INTERFACE:
            case self::MOCK_CLASS:
            case self::MOCK_ABSTRACT_CLASS:
                $this->expectFailure(
                    "You cannot expose a method on a mock that is not nice."
                );
        }
    }

    /**
     * @group #189
     * @dataProvider allBuilders
     */
    public function testExposeASingleMethod(MockBuilder $builder, $type)
    {
        $this->youCannotExposeAMethodOnAMockThatIsNotNice($type);
        $mock = $builder->expose('mySecretMethod')->get();
        $this->assert($mock->myMethod(), equals, 'abc');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage does not exist.
     * @group #189
     * @dataProvider allBuilders
     */
    public function testAnExceptionIsThrownIfTheMethodDoesNotExist(
        MockBuilder $builder,
        $type
    ) {
        $this->youCannotExposeAMethodOnAMockThatIsNotNice($type);
        $builder->expose('baz')->get();
    }

    /**
     * @group #189
     * @dataProvider allBuilders
     */
    public function testExposeTwoMethodsWithSeparateParameters(
        MockBuilder $builder,
        $type
    ) {
        $this->youCannotExposeAMethodOnAMockThatIsNotNice($type);
        $mock = $builder->expose('myMethod', 'mySecondMethod')->get();
        $this->assert($mock->mySecondMethod(), equals, 'bar');
    }

    /**
     * @group #189
     * @dataProvider allBuilders
     */
    public function testExposeTwoMethodsByCallingExposeTwice(
        MockBuilder $builder,
        $type
    ) {
        $this->youCannotExposeAMethodOnAMockThatIsNotNice($type);
        $mock = $builder->expose('myMethod')->expose('mySecondMethod')->get();
        $this->assert($mock->myMethod(), equals, 'abc');
    }

    /**
     * @group #189
     * @dataProvider allBuilders
     */
    public function testExposeTwoMethodsWithArraySyntax(
        MockBuilder $builder,
        $type
    ) {
        $this->youCannotExposeAMethodOnAMockThatIsNotNice($type);
        $mock = $builder->expose(array('myMethod', 'mySecondMethod'))->get();
        $this->assert($mock->mySecondMethod(), equals, 'bar');
    }

    /**
     * @group #189
     * @dataProvider allBuilders
     */
    public function testExposeAllCanBeChained(MockBuilder $builder, $type)
    {
        $this->youCannotExposeAMethodOnAMockThatIsNotNice($type);
        $this->assert($builder->exposeAll(), is_the_same_as, $builder);
    }

    /**
     * @group #189
     * @dataProvider allBuilders
     */
    public function testExposeAllMethodsWillExposeAllMethods(
        MockBuilder $builder,
        $type
    ) {
        $this->youCannotExposeAMethodOnAMockThatIsNotNice($type);
        $mock = $builder->exposeAll()->get();
        $this->assert($mock->mySecretMethod(), equals, 'abc');
    }
}
