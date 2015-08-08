<?php

namespace Concise\Modules\RegularExpressions;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class DoesNotMatchRegularExpressionTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new DoesNotMatchRegularExpression();
    }

    public function testDoesNotMatchRegularExpression()
    {
        $this->assert("abc", does_not_match_regex, '/^f/');
    }

    public function testDoesNotMatchRegularExpressionFailure()
    {
        $this->assertFailure("foo", does_not_match_regex, '/^f/');
    }
}
