<?php

namespace Concise\Matcher;

class DoesNotHaveValueTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new DoesNotHaveValue();
    }

    public function testArrayValueExists()
    {
        $this->assertFailure('[123] does not have value 123');
    }

    public function testArrayValueDoesNotExist()
    {
        $this->assert('["abc"] does not contain "def"');
    }
}
