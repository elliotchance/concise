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
        $this->aassert($this->simplifier->render(array()))->equals('');
    }

    public function testOneItemWillPrintSimplifiedFile()
    {
        $this->aassert(
            $this->simplifier->render(
                array(
                    array(
                        'file' => getcwd() . '/foo.php',
                        'function' => 'myFunction',
                    ),
                )
            )
        )->containsString('foo.php');
    }

    public function testWillSkipTraceLineIfItsTheConciseExecutable()
    {
        $this->aassert(
            $this->simplifier->render(
                array(
                    array(
                        'file' => getcwd() . '/bin/concise',
                        'function' => 'myFunction',
                    ),
                )
            )
        )->equals('');
    }

    public function testWillSkipTraceLineIfThePathIsInTheVendorFolder()
    {
        $this->aassert(
            $this->simplifier->render(
                array(
                    array(
                        'file' => getcwd() . '/vendor/a',
                        'function' => 'myFunction',
                    ),
                )
            )
        )->equals('');
    }

    public function testUsesUnknownFileIfNotSpecified()
    {
        $this->aassert(
            $this->simplifier->render(
                array(
                    array(
                        'function' => 'myFunction',
                    ),
                )
            )
        )->containsString('(unknown file)');
    }

    public function testWillUseAQuestionMarkIfTheLineIsNotSpecified()
    {
        $this->aassert(
            $this->simplifier->render(
                array(
                    array(
                        'function' => 'myFunction',
                    ),
                )
            )
        )->containsString('Line ?');
    }

    public function testWillIncludeLineNumber()
    {
        $this->aassert(
            $this->simplifier->render(
                array(
                    array(
                        'line' => 123,
                        'function' => 'myFunction',
                    ),
                )
            )
        )->containsString('Line 123');
    }

    public function testWillGroupLinesUnderTheSameHeadingIfTheyAreTheSameFile()
    {
        $result = $this->simplifier->render(
            array(
                array(
                    'file' => getcwd() . '/foo.php',
                    'function' => 'myFunction',
                ),
                array(
                    'file' => getcwd() . '/foo.php',
                    'function' => 'myFunction',
                ),
            )
        );
        $this->aassert(substr_count($result, 'foo.php'))->equals(1);
    }

    public function testWillIncludeTheFunctionName()
    {
        $this->aassert(
            $this->simplifier->render(
                array(
                    array(
                        'function' => 'myFunction',
                    ),
                )
            )
        )->containsString('myFunction()');
    }

    public function testWillIncludeClassIfAvailable()
    {
        $this->aassert(
            $this->simplifier->render(
                array(
                    array(
                        'function' => 'myFunction',
                        'class' => 'MyClass',
                        'type' => '',
                    ),
                )
            )
        )->containsString('MyClass');
    }

    public function testWillIncludeTypeIfClassIsAvailable()
    {
        $this->aassert(
            $this->simplifier->render(
                array(
                    array(
                        'function' => 'myFunction',
                        'class' => 'MyClass',
                        'type' => '::',
                    ),
                )
            )
        )->containsString('MyClass::myFunction()');
    }
}
