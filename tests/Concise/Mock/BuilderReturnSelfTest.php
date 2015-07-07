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
        $this->assert($mock->myMethod(), is_the_same_as, $mock);
    }
}
