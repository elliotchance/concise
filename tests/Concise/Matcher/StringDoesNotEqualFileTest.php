<?php

namespace Concise\Matcher;

class StringDoesNotEqualFileTest extends AbstractFileTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new StringDoesNotEqualFile();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage File 'bar' does not exist.
     */
    public function testExceptionIsThrownIfFileDoesNotExist()
    {
        $this->assert('foo', does_not_equal_file, 'bar');
    }

    public function testWillFailIfStringDoesNotMatchFile()
    {
        $this->assert('bar', does_not_equal_file, $this->createTempFile());
    }

    public function testWillSucceedIfStringDoesMatchFile()
    {
        $this->assertFailure('baz', does_not_equal_file, $this->createTempFile());
    }
}
