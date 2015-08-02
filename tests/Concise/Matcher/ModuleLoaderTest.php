<?php

namespace Concise\Matcher;

use Concise\TestCase;

/**
 * @group matcher
 */
class ModuleLoaderTest extends TestCase
{
    public function testLoadingAModuleReturnsAModuleObject()
    {
        $loader = new ModuleLoader();
        $this->assert(
            $loader->load(['module' => ['name' => "test"]]),
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
        $loader = new ModuleLoader();
        $loader->load([]);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage A module must have a name defined.
     */
    public function testModuleMustHaveAName()
    {
        $loader = new ModuleLoader();
        $loader->load(['module' => []]);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The module name must be a string.
     */
    public function testModuleNameMustBeAString()
    {
        $loader = new ModuleLoader();
        $loader->load(['module' => ['name' => 123]]);
    }
}
