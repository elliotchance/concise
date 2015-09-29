<?php

namespace Concise\Module;

use Concise\Core\TestCase;

class MyMatcher extends AbstractModule
{
    /**
     * @syntax ? foo bar ?
     */
    public function foo()
    {
        return false;
    }

    public function getName()
    {
    }
}

/**
 * @group matcher
 */
class AbstractModuleTest extends TestCase
{
    /**
     * @var MyMatcher
     */
    protected $module;

    public function setUp()
    {
        parent::setUp();
        $this->module = new MyMatcher();
    }

    public function testDefaultRendererWorks()
    {
        $this->assertString($this->module->renderFailureMessage(''))->isEmpty;
    }

    public function testGetSyntaxesForMethod()
    {
        $this->assertArray($this->module->getSyntaxes())->isNotEmpty;
    }
}
