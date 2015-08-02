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
            $loader->loadFromString(),
            instance_of,
            '\Concise\Matcher\Module'
        );
    }
}
