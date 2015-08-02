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
            $loader->parse(['module' => ['name' => "test"]]),
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
        $module = $loader->parse(['module' => ['name' => "test"]]);
        $this->assert($module->getName(), equals, 'test');
    }
}
