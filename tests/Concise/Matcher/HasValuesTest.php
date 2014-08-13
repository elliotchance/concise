<?php

namespace Concise\Matcher;

class HasValuesTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new HasValues();
    }

    public function testArrayHasOneValue()
    {
        $this->assert('[123] has values [123]');
    }

    public function testArrayDoesNotContainAllValues()
    {
        $this->assertFailure('[123] has values [0,123]');
    }

    public function testArrayValuesCanBeInAnyOrder()
    {
        $this->assert('["a":123,"b":456] has values [123,456]');
    }

    public function testArrayValuesCanBeASubset()
    {
        $this->assert('["a":123,"b":456] has values [456]');
    }
}
