<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Concise\TestCase;

class TraceSimplifierTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->simplifier = new TraceSimplifier();
    }

    public function testZeroItemsInTraceWillNotRenderAnything()
    {
        $this->assert($this->simplifier->render(array()), equals, '');
    }

    public function testOneItemWillPrintSimplifiedFile()
    {
        $this->assert($this->simplifier->render(array(
            array(
                'file' => getcwd() . '/foo.php',
            ),
        )), contains_string, 'foo.php');
    }

    public function testWillSkipTraceLineIfItsTheConciseExecutable()
    {
        $this->assert($this->simplifier->render(array(
            array(
                'file' => getcwd() . '/bin/concise',
            ),
        )), equals, '');
    }

    public function testWillSkipTraceLineIfThePathIsInTheVendorFolder()
    {
        $this->assert($this->simplifier->render(array(
            array(
                'file' => getcwd() . '/vendor/a',
            ),
        )), equals, '');
    }

    public function testUsesUnknownFileIfNotSpecified()
    {
        $this->assert($this->simplifier->render(array(
            array(
            ),
        )), contains_string, '(unknown file)');
    }

    public function testWillUseAQuestionMarkIfTheLineIsNotSpecified()
    {
        $this->assert($this->simplifier->render(array(
            array(
            ),
        )), contains_string, 'Line ?');
    }

    public function testWillIncludeLineNumber()
    {
        $this->assert($this->simplifier->render(array(
            array(
                'line' => 123,
            ),
        )), contains_string, 'Line 123');
    }
}
