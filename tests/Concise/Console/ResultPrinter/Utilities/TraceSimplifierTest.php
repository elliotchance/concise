<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Concise\TestCase;

class TraceSimplifierTest extends TestCase
{
    public function testZeroItemsInTraceWillNotRenderAnything()
    {
        $simplifier = new TraceSimplifier();
        $this->assert($simplifier->render(array()), equals, '');
    }

    public function testOneItemWillPrintSimplifiedFile()
    {
        $simplifier = new TraceSimplifier();
        $this->assert($simplifier->render(array(
            array(
                'file' => getcwd() . '/foo.php',
            ),
        )), contains_string, 'foo.php');
    }

    public function testWillSkipTraceLineIfItsTheConciseExecutable()
    {
        $simplifier = new TraceSimplifier();
        $this->assert($simplifier->render(array(
            array(
                'file' => getcwd() . '/bin/concise',
            ),
        )), equals, '');
    }
}
