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
        $this->assert("abc", does_not_match_regex, '/^f/');
    }

    public function testDoesNotMatchRegularExpressionFailure()
    {
        $this->assertFailure("foo", does_not_match_regex, '/^f/');
    }

    public function tags()
    {
        return array(Tag::REGEX);
    }
}
