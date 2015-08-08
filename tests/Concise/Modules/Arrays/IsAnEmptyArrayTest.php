<?php

namespace Concise\Modules\Arrays;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class IsAnEmptyArrayTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsAnEmptyArray();
    }

    public function testArrayWithZeroElements()
    {
        $this->assert(array(), is_empty_array);
    }

    public function testArrayWithMoreThanZeroElements()
    {
        $this->assertFailure(array('a'), is_empty_array);
    }
}
