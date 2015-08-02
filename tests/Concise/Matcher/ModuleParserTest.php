<?php

namespace Concise\Matcher;

use Concise\TestCase;

/**
 * @group matcher
 */
class ModuleParserTest extends TestCase
{
    public function testLoadingAModuleReturnsAModuleObject()
    {
        $loader = new ModuleParser();
        $this->assert(
            $loader->parse($this->getModule()),
            instance_of,
            '\Concise\Matcher\Module'
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Missing 'module' at root.
     */
    public function testMissingModuleKeyThrowsException()
    {
        $loader = new ModuleParser();
        $loader->parse([]);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage A module must have a name defined.
     */
    public function testModuleMustHaveAName()
    {
        $loader = new ModuleParser();
        $loader->parse(['module' => []]);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The module name must be a string.
     */
    public function testModuleNameMustBeAString()
    {
        $loader = new ModuleParser();
        $loader->parse(['module' => ['name' => 123]]);
    }

    public function testModuleNameIsSet()
    {
        $loader = new ModuleParser();
        $module = $loader->parse($this->getModule());
        $this->assert($module->getName(), equals, 'test');
    }

    public function testDescriptionIsSet()
    {
        $loader = new ModuleParser();
        $module = $loader->parse($this->getModule());
        $this->assert($module->getDescription(), equals, 'desc');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The module description must be a string.
     */
    public function testModuleDescriptionMustBeAString()
    {
        $loader = new ModuleParser();
        $module = $this->getModule();
        $module['module']['description'] = [];
        $loader->parse($module);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage A module must have syntaxes.
     */
    public function testModuleMustHaveSyntaxes()
    {
        $loader = new ModuleParser();
        $loader->parse(
            ['module' => ['name' => "test"]]
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The module syntaxes must be an array.
     */
    public function testSyntaxesMustBeAnArray()
    {
        $loader = new ModuleParser();
        $module = $this->getModule();
        $module['module']['syntaxes'] = 123;
        $loader->parse($module);
    }

    /**
     * @return array
     */
    public function getModule()
    {
        return [
            'module' => [
                'name' => "test",
                'description' => 'desc',
                'syntaxes' => [
                    '? equals ?' => 1
                ]
            ]
        ];
    }
}
