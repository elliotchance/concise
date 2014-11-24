<?php

namespace Concise\Matcher;

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

    public function tags()
    {
        return array(Tag::STRINGS);
    }
}
