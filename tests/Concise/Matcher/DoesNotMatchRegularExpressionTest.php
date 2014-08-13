<?php

namespace Concise\Matcher;

class DoesNotMatchRegularExpressionTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new DoesNotMatchRegularExpression();
    }

    public function testDoesNotMatchRegularExpression()
    {
        $this->assert('"abc" does not match regex /^f/');
    }

    public function testDoesNotMatchRegularExpressionFailure()
    {
        $this->assertFailure('"foo" does not match regex /^f/');
    }
}
