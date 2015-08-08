<?php

namespace Concise\Matcher;

use Closure;

/**
 * @group matcher
 */
class DoesNotThrowTest extends AbstractExceptionTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new DoesNotThrow();
    }

    public function exceptionTests()
    {
        return $this->createExceptionTests(
            array(
                array('throwNothing', 'expectException', 'FAIL'),
                array('throwNothing', 'expectMyException', 'FAIL'),
                array('throwException', 'expectException', 'PASS'),
                array('throwException', 'expectMyException', 'FAIL'),
                array('throwMyException', 'expectException', 'PASS'),
                array('throwMyException', 'expectMyException', 'PASS'),
                array('throwMyException', 'expectOtherException', 'FAIL'),
                array('throwOtherException', 'expectException', 'PASS'),
                array('throwOtherException', 'expectMyException', 'FAIL'),
                array('throwOtherException', 'expectOtherException', 'PASS'),
            )
        );
    }

    public function exceptionDoesNotThrowTestMessages()
    {
        return $this->createExceptionTests(
            array(
                array(
                    'throwException',
                    'expectException',
                    "Expected Exception not to be thrown, but Exception was thrown."
                ),
                array(
                    'throwMyException',
                    'expectException',
                    "Expected Exception not to be thrown, but Concise\Matcher\MyException was thrown."
                ),
                array(
                    'throwMyException',
                    'expectMyException',
                    "Expected Concise\Matcher\MyException not to be thrown, but Concise\Matcher\MyException was thrown."
                ),
                array(
                    'throwOtherException',
                    'expectException',
                    "Expected Exception not to be thrown, but Concise\Matcher\OtherException was thrown."
                ),
                array(
                    'throwOtherException',
                    'expectOtherException',
                    "Expected Concise\Matcher\OtherException not to be thrown, but Concise\Matcher\OtherException was thrown."
                ),
            )
        );
    }

    /**
     * @dataProvider exceptionTests
     */
    public function testDoesNotThrow(
        Closure $method,
        $expectedException,
        $expectToThrow
    ) {
        if ($expectToThrow) {
            $this->assertMatcherSuccess(
                '? does not throw ?',
                array($method, $expectedException)
            );
        } else {
            $this->assertMatcherFailure(
                '? does not throw ?',
                array($method, $expectedException)
            );
        }
    }

    /**
     * @dataProvider exceptionDoesNotThrowTestMessages
     */
    public function testDoesNotThrowMessages(
        Closure $method,
        $expectedException,
        $failureMessage
    ) {
        $this->assertMatcherFailureMessage(
            '? does not throw ?',
            array($method, $expectedException),
            $failureMessage
        );
    }

    public function tags()
    {
        return array();
    }
}
