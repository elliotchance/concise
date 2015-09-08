<?php

namespace Concise\Mock;

/**
 * @group mocking
 */
class BuilderReturnSelfTest extends AbstractBuilderTestCase
{
    /**
     * @dataProvider allBuilders
     */
    public function testMethodsCanReturnSelf(MockBuilder $builder)
    {
        $mock = $builder->stub('myMethod')->andReturnSelf()->get();
        $this->aassert($mock->myMethod())->isTheSameAs($mock);
    }
}
