<?php

namespace Concise\Module;

class FileModuleTest extends AbstractModuleTestCase
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

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testWillFailIfStringDoesNotMatchFile()
    {
        $this->aassert('bar')->equalsFile($this->createTempFile());
    }

    public function testWillSucceedIfStringDoesMatchFile()
    {
        $this->aassert('baz')->equalsFile($this->createTempFile());
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
        $this->aassert('bar')->doesNotEqualFile($this->createTempFile());
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testWillSucceedIfStringDoesMatchFile1()
    {
        $this->aassert('baz')->doesNotEqualFile($this->createTempFile());
    }
}
