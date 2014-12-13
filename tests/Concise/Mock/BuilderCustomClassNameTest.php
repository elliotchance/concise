<?php

namespace Concise\Mock;

/**
 * @group mocking
 */
class BuilderCustomClassNameTest extends AbstractBuilderTestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid class name 'Concise\Mock\123'.
     * @dataProvider allBuilders
     */
    public function testWillThrowExceptionIfTheCustomNameIsNotValid(MockBuilder $builder)
    {
        $builder->setCustomClassName('123')->get();
    }

    /**
     * @dataProvider allBuilders
     */
    public function testCanSetCustomClassName(MockBuilder $builder)
    {
        $rand = "Concise\\Mock\\Temp" . md5(rand());
        $mock = $builder->setCustomClassName($rand)->get();
        $this->assert(get_class($mock), equals, $rand);
    }
}
