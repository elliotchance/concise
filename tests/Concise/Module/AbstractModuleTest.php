<?php

namespace Concise\Module;

use Concise\Core\TestCase;

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
        $this->assert($this->matcher->renderFailureMessage(''))->isBlank;
    }
}
