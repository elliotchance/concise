<?php

namespace Concise\Matcher;

use Concise\TestCase;

class MyMatcher extends AbstractMatcher
{
    public function match()
    {
        return false;
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
        $this->assert($this->matcher->renderFailureMessage(''), is_blank);
    }
}
