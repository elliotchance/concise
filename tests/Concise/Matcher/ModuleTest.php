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
}
