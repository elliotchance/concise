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
            $loader->loadFromYaml(''),
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
}
