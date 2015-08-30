<?php

namespace Concise\Module;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class RegularExpressionModuleTest extends AbstractModuleTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new RegularExpressionModule();
    }

    public function testMatchesRegularExpression()
    {
        $this->assert("123", matches_regular_expression, '/\\d+/');
    }

    public function testMatchesRegularExpressionFailure()
    {
        $this->assertFailure("abc", matches_regular_expression, '/\\d+/');
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
