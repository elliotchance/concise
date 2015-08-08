<?php

namespace Concise\Modules\Arrays;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
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
        $this->assert(
            array("a" => 123, "b" => 456),
            has_values,
            array(123, 456)
        );
    }

    public function testArrayValuesCanBeASubset()
    {
        $this->assert(array("a" => 123, "b" => 456), has_values, array(456));
    }
}
