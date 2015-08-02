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
            $loader->loadFromYaml("module:\n  name: test"),
            instance_of,
            '\Concise\Matcher\Module'
        );
    }

    /**
     * @expectedException \Symfony\Component\Yaml\Exception\ParseException
     */
    public function testInvalidYamlThrowsException()
    {
        $loader = new ModuleLoader();
        $loader->loadFromYaml('[');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Missing 'module' at Yaml root.
     */
    public function testMissingModuleKeyThrowsException()
    {
        $loader = new ModuleLoader();
        $loader->loadFromYaml('abc: def');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Yaml root must be an array.
     */
    public function testWrongTypeOfRootYaml()
    {
        $loader = new ModuleLoader();
        $loader->loadFromYaml('123');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage A module must have a name defined.
     */
    public function testModuleMustHaveAName()
    {
        $loader = new ModuleLoader();
        $loader->loadFromYaml('module: []');
    }
}
