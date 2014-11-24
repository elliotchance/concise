<?php

namespace Concise\Matcher;

/**
 * @group matcher
 */
class StringDoesNotEqualFileTest extends AbstractFileTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new StringDoesNotEqualFile();
    }

    /**
     * @expectedException \Concise\Matcher\DidNotMatchException
     * @expectedExceptionMessage File 'bar' does not exist.
     */
    public function testExceptionIsThrownIfFileDoesNotExist()
    {
        $this->matcher->match(null, array('foo', 'bar'));
    }

    public function testWillFailIfStringDoesNotMatchFile()
    {
        $this->assert('bar', does_not_equal_file, $this->createTempFile());
    }

    public function testWillSucceedIfStringDoesMatchFile()
    {
        $this->assertFailure('baz', does_not_equal_file, $this->createTempFile());
    }

    public function tags()
    {
        return array(Tag::STRINGS);
    }
}
