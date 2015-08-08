<?php

namespace Concise\Modules\RegularExpressions;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class MatchesRegularExpressionTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new MatchesRegularExpression();
    }

    public function testMatchesRegularExpression()
    {
        $this->assert('"123" matches regular expression /\\d+/');
    }

    public function testMatchesRegularExpressionFailure()
    {
        $this->assertFailure('"abc" matches regular expression /\\d+/');
    }
}
