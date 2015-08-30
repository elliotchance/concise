<?php

namespace Concise\Module;

use Concise\TestCase;

class MyMatcher extends AbstractModule
{
    public function match()
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
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new MyMatcher();
    }

    public function testDefaultRendererWorks()
    {
        $this->aassert($this->matcher->renderFailureMessage(''))->isBlank;
    }
}
