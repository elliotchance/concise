<?php

namespace Concise\Matcher;

class IsFalsyTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsTrue();
    }

    public function testFalseIsFalsy()
    {
        $this->assert(false, is_falsy);
    }
}
