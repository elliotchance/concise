<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Concise\TestCase;

class FilePathSimplifierTest extends TestCase
{
    public function testReturnsPathIfNotInTheCurrentWorkingDirectory()
    {
        $simplifier = new FilePathSimplifier();
        $this->assert($simplifier->process('foo'))->equals('foo');
    }

    public function testWillCropOffCurrentWorkingDirectory()
    {
        $simplifier = new FilePathSimplifier();
        $this->assert($simplifier->process(getcwd() . '/foo/bar'))
            ->equals('foo/bar');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected string, but got integer for argument 1
     */
    public function testFilePathMustBeAString()
    {
        $simplifier = new FilePathSimplifier();
        $simplifier->process(123);
    }
}
