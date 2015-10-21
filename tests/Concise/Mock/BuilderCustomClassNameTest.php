<?php

namespace Concise\Mock;

class FooClass
{
}

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
    public function testWillThrowExceptionIfTheCustomNameIsNotValid(
        MockBuilder $builder
    ) {
        $builder->setCustomClassName('123')->get();
    }

    /**
     * @dataProvider allBuilders
     */
    public function testCanSetCustomClassName(MockBuilder $builder)
    {
        $rand = "Concise\\Mock\\Temp" . md5(rand());
        $mock = $builder->setCustomClassName($rand)->get();
        $this->assert(get_class($mock))->equals($rand);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage You cannot use 'Concise\Mock\FooClass' because
     *     a class with that name already exists.
     * @dataProvider allBuilders
     * @group #304
     */
    public function testWillThrowExceptionIfTheCustomNameAlreadyExists(
        MockBuilder $builder
    ) {
        $builder->setCustomClassName('Concise\Mock\FooClass')->get();
    }

    /**
     * @dataProvider allBuilders
     * @group #304
     */
    public function testCustomClassNameWillNotActivateClassLoader(
        MockBuilder $builder
    ) {
        spl_autoload_register(
            function () {
                throw new \Exception("Autoloader should not have been called.");
            }
        );

        $rand = "Concise\\Mock\\Temp" . md5(rand());
        $builder->setCustomClassName($rand)->get();

        $functions = spl_autoload_functions();
        spl_autoload_unregister($functions[count($functions) - 1]);
    }
}
