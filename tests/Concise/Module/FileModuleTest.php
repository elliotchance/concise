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
     * @expectedExceptionMessage File 'foo' does not exist.
     */
    public function testExceptionIsThrownIfFileDoesNotExist()
    {
        $this->assertFile('foo')->equals('bar');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testWillFailIfStringDoesNotMatchFile()
    {
        $this->assertFile($this->createTempFile())->equals('bar');
    }

    public function testWillSucceedIfStringDoesMatchFile()
    {
        $this->assertFile($this->createTempFile())->equals('baz');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     * @expectedExceptionMessage File 'foo' does not exist.
     */
    public function testExceptionIsThrownIfFileDoesNotExist1()
    {
        $this->assertFile('foo')->doesNotEqual('bar');
    }

    public function testWillFailIfStringDoesNotMatchFile1()
    {
        $this->assertFile($this->createTempFile())->doesNotEqual('bar');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testWillSucceedIfStringDoesMatchFile1()
    {
        $this->assertFile($this->createTempFile())->doesNotEqual('baz');
    }
}
