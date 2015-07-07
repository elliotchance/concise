<?php

namespace Concise\Mock;

/**
 * @group mocking
 */
class BuilderStaticTest extends AbstractBuilderTestCase
{
    /**
     * @dataProvider allBuilders
     */
    public function testMocksCanMockStaticMethods(MockBuilder $builder)
    {
        $mock = $builder->stub(array('myStaticMethod' => 'foo'))->get();
        $this->assert($mock->myStaticMethod(), equals, 'foo');
    }
}
