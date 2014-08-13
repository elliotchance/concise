<?php

namespace Concise\Matcher;

class StringEqualsFileTest extends AbstractMatcherTestCase
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
        $fileName = tempnam('', 'concise');
        file_put_contents($fileName, 'baz');
        $this->assertFailure('bar', equals_file, $fileName);
    }
}
