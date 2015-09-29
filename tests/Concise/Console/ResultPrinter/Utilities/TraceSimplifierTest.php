<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Concise\Core\TestCase;

class TraceSimplifierTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->simplifier = new TraceSimplifier();
    }

    public function testZeroItemsInTraceWillNotRenderAnything()
    {
        $this->assert($this->simplifier->render(array()))->equals('');
    }

    public function testOneItemWillPrintSimplifiedFile()
    {
        $this->assertString(
            $this->simplifier->render(
                array(
                    array(
                        'file' => getcwd() . '/foo.php',
                        'function' => 'myFunction',
                    ),
                )
            )
        )->contains('foo.php');
    }

    public function testWillSkipTraceLineIfItsTheConciseExecutable()
    {
        $this->assert(
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
        $this->assert(
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
        $this->assertString(
            $this->simplifier->render(
                array(
                    array(
                        'function' => 'myFunction',
                    ),
                )
            )
        )->contains('(unknown file)');
    }

    public function testWillUseAQuestionMarkIfTheLineIsNotSpecified()
    {
        $this->assertString(
            $this->simplifier->render(
                array(
                    array(
                        'function' => 'myFunction',
                    ),
                )
            )
        )->contains('Line ?');
    }

    public function testWillIncludeLineNumber()
    {
        $this->assertString(
            $this->simplifier->render(
                array(
                    array(
                        'line' => 123,
                        'function' => 'myFunction',
                    ),
                )
            )
        )->contains('Line 123');
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
        $this->assert(substr_count($result, 'foo.php'))->equals(1);
    }

    public function testWillIncludeTheFunctionName()
    {
        $this->assertString(
            $this->simplifier->render(
                array(
                    array(
                        'function' => 'myFunction',
                    ),
                )
            )
        )->contains('myFunction()');
    }

    public function testWillIncludeClassIfAvailable()
    {
        $this->assertString(
            $this->simplifier->render(
                array(
                    array(
                        'function' => 'myFunction',
                        'class' => 'MyClass',
                        'type' => '',
                    ),
                )
            )
        )->contains('MyClass');
    }

    public function testWillIncludeTypeIfClassIsAvailable()
    {
        $this->assertString(
            $this->simplifier->render(
                array(
                    array(
                        'function' => 'myFunction',
                        'class' => 'MyClass',
                        'type' => '::',
                    ),
                )
            )
        )->contains('MyClass::myFunction()');
    }
}
