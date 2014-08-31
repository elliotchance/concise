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
                'function' => 'myFunction',
            ),
        )), contains_string, 'foo.php');
    }

    public function testWillSkipTraceLineIfItsTheConciseExecutable()
    {
        $this->assert($this->simplifier->render(array(
            array(
                'file' => getcwd() . '/bin/concise',
                'function' => 'myFunction',
            ),
        )), equals, '');
    }

    public function testWillSkipTraceLineIfThePathIsInTheVendorFolder()
    {
        $this->assert($this->simplifier->render(array(
            array(
                'file' => getcwd() . '/vendor/a',
                'function' => 'myFunction',
            ),
        )), equals, '');
    }

    public function testUsesUnknownFileIfNotSpecified()
    {
        $this->assert($this->simplifier->render(array(
            array(
                'function' => 'myFunction',
            ),
        )), contains_string, '(unknown file)');
    }

    public function testWillUseAQuestionMarkIfTheLineIsNotSpecified()
    {
        $this->assert($this->simplifier->render(array(
            array(
                'function' => 'myFunction',
            ),
        )), contains_string, 'Line ?');
    }

    public function testWillIncludeLineNumber()
    {
        $this->assert($this->simplifier->render(array(
            array(
                'line' => 123,
                'function' => 'myFunction',
            ),
        )), contains_string, 'Line 123');
    }

    public function testWillGroupLinesUnderTheSameHeadingIfTheyAreTheSameFile()
    {
        $result = $this->simplifier->render(array(
            array(
                'file' => getcwd() . '/foo.php',
                'function' => 'myFunction',
            ),
            array(
                'file' => getcwd() . '/foo.php',
                'function' => 'myFunction',
            ),
        ));
        $this->assert(substr_count($result, 'foo.php'), equals, 1);
    }

    public function testWillIncludeTheFunctionName()
    {
        $this->assert($this->simplifier->render(array(
            array(
                'function' => 'myFunction',
            ),
        )), contains_string, 'myFunction()');
    }
}
