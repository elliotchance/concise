<?php

namespace Concise\Modules\Strings;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class IsBlankTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsBlank();
    }

    public function testStringWithNoCharactersIsBlank()
    {
        $this->assert('', is_blank);
    }

    public function testStringWithAtLeastOneCharacterIsNotBlank()
    {
        $this->assertFailure('a', is_blank);
    }
}
