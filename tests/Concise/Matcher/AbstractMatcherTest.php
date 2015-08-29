<?php

namespace Concise\Matcher;

use Concise\TestCase;

class MyMatcher extends AbstractMatcher
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
class AbstractMatcherTest extends TestCase
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
