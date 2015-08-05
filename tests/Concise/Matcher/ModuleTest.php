<?php

namespace Concise\Matcher;

use Concise\TestCase;

/**
 * @group matcher
 */
class ModuleTest extends TestCase
{
    public function testModuleHasName()
    {
        $module = new Module('Foo');
        $this->assert($module->getName(), equals, 'Foo');
    }

    public function testModuleNameIsSetByConstructor()
    {
        $module = new Module('Bar');
        $this->assert($module->getName(), equals, 'Bar');
    }

    public function testDefaultDescriptionIsBlank()
    {
        $module = new Module('Bar');
        $this->assert($module->getDescription(), equals, '');
    }

    public function testSettingDescription()
    {
        $module = new Module('Bar');
        $module->setDescription('foo');
        $this->assert($module->getDescription(), equals, 'foo');
    }

    public function testSyntaxesAreEmptyByDefault()
    {
        $module = new Module('Foo');
        $this->assert($module->getSyntaxes(), equals, []);
    }

    public function testModuleSyntaxesSetInConstructor()
    {
        $module =
            new Module('Foo', ['? equals ?' => ['method' => 'stdClass::foo']]);
        $this->assert(count($module->getSyntaxes()), equals, 1);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Missing 'method' for '? equals ?'.
     */
    public function testMethodIsMissing()
    {
        new Module('Foo', ['? equals ?' => []]);
    }
}
