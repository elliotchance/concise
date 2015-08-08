<?php

namespace Concise\Modules\Strings;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class IsNotBlankTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsNotBlank();
    }

    public function testStringWithNoCharactersIsBlank()
    {
        $this->assertFailure('', is_not_blank);
    }

    public function testStringWithAtLeastOneCharacterIsNotBlank()
    {
        $this->assert('a', is_not_blank);
    }
}
