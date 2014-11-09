<?php

namespace Concise\Matcher;

class StringEqualsFileTest extends AbstractFileTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new StringEqualsFile();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage File 'bar' does not exist.
     */
    public function testExceptionIsThrownIfFileDoesNotExist()
    {
        $this->assert('foo', equals_file, 'bar');
    }

    public function testWillFailIfStringDoesNotMatchFile()
    {
        $this->assertFailure('bar', equals_file, $this->createTempFile());
    }

    public function testWillSucceedIfStringDoesMatchFile()
    {
        $this->assert('baz', equals_file, $this->createTempFile());
    }

    public function tags()
    {
        return array(Tag::STRINGS);
    }
}
