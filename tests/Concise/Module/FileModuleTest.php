<?php

namespace Concise\Module;

use Concise\Matcher\AbstractMatcherTestCase;

class FileModuleTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new FileModule();
    }

    protected function createTempFile()
    {
        $fileName = tempnam('', 'concise');
        file_put_contents($fileName, 'baz');
        return $fileName;
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage File 'bar' does not exist.
     */
    public function testExceptionIsThrownIfFileDoesNotExist()
    {
        $this->matcher->setData(array('foo', 'bar'));
        $this->matcher->stringEqualsFile();
    }

    public function testWillFailIfStringDoesNotMatchFile()
    {
        $this->assertFailure('bar', equals_file, $this->createTempFile());
    }

    public function testWillSucceedIfStringDoesMatchFile()
    {
        $this->assert('baz', equals_file, $this->createTempFile());
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     * @expectedExceptionMessage File 'bar' does not exist.
     */
    public function testExceptionIsThrownIfFileDoesNotExist1()
    {
        $this->matcher->setData(array('foo', 'bar'));
        $this->matcher->stringDoesNotEqualFile();
    }

    public function testWillFailIfStringDoesNotMatchFile1()
    {
        $this->assert('bar', does_not_equal_file, $this->createTempFile());
    }

    public function testWillSucceedIfStringDoesMatchFile1()
    {
        $this->assertFailure(
            'baz',
            does_not_equal_file,
            $this->createTempFile()
        );
    }
}
