<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Concise\TestCase;

class FilePathSimplifierTest extends TestCase
{
    public function testReturnsPathIfNotInTheCurrentWorkingDirectory()
    {
        $simplifier = new FilePathSimplifier();
        $this->assert($simplifier->process('foo'), equals, 'foo');
    }
}
