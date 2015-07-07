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
     * @group #129
     */
    public function testFinalClassesCanNotBeMocked(MockBuilder $builder)
    {
        $builder->get();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage is final so it cannot be mocked
     * @dataProvider niceMockBuilders
     * @group #129
     */
    public function testFinalMethodsCanNotBeMocked(MockBuilder $builder)
    {
        $builder->stub('myFinalMethod')->get();
    }
}
