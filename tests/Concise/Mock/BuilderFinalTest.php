<?php

namespace Concise\Mock;

/**
 * @group mocking
 */
class BuilderFinalTest extends AbstractBuilderTestCase
{
    /**
     * @expectedException \Exception
     * @expectedExceptionMessage is final so it cannot be mocked
     * @dataProvider finalBuilders
     */
    public function testFinalMethodsCanNotBeMocked(MockBuilder $builder)
    {
        $builder->stub('myFinalMethod')
            ->get();
    }
}
