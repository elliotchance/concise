<?php

namespace Concise\Modules\Types;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class IsNullTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsNull();
    }

    public function testIsNull()
    {
        $this->assert(null, is_null);
    }

    public function testIsNullFailure()
    {
        $this->assertFailure('123 is null');
    }
}
