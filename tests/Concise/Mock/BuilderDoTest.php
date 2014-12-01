<?php

namespace Concise\Mock;

/**
 * @group mocking
 */
class BuilderDoTest extends AbstractBuilderTestCase
{
    /**
     * @dataProvider allBuilders
     */
    public function testACallbackCanBeSet(MockBuilder $builder)
    {
        $mock = $builder->stub('myMethod')->andDo(function () {})
            ->get();
        $this->assert($mock->myMethod(), equals, null);
    }
}
