<?php

namespace Concise\Modules\Booleans;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class FalseTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new False();
    }

    public function testAlwaysFails()
    {
        $this->assertFailure('false');
    }
}
