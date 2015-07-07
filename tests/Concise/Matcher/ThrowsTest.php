<?php

namespace Concise\Matcher;

/**
 * @group matcher
 */
class ThrowsTest extends AbstractExceptionTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new Throws();
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

    public function exceptionThrowsTestMessages()
    {
        return $this->createExceptionTests(
            array(
                array(
                    'throwNothing',
                    'expectException',
                    "Expected Exception to be thrown, but nothing was thrown."
                ),
                array(
                    'throwNothing',
                    'expectMyException',
                    "Expected Concise\Matcher\MyException to be thrown, but nothing was thrown."
                ),
                array(
                    'throwException',
                    'expectMyException',
                    "Expected Concise\Matcher\MyException to be thrown, but Exception was thrown."
                ),
                array(
                    'throwMyException',
                    'expectOtherException',
                    "Expected Concise\Matcher\OtherException to be thrown, but Concise\Matcher\MyException was thrown."
                ),
                array(
                    'throwOtherException',
                    'expectMyException',
                    "Expected Concise\Matcher\MyException to be thrown, but Concise\Matcher\OtherException was thrown."
                ),
            )
        );
    }

    /**
     * @dataProvider exceptionTests
     */
    public function testThrows(
        \Closure $method,
        $expectedException,
        $expectToThrow
    ) {
        if ($expectToThrow) {
            $this->assertMatcherFailure(
                '? throws ?',
                array($method, $expectedException)
            );
        } else {
            $this->assertMatcherSuccess(
                '? throws ?',
                array($method, $expectedException)
            );
        }
    }

    /**
     * @dataProvider exceptionThrowsTestMessages
     */
    public function testThrowsMessages(
        \Closure $method,
        $expectedException,
        $failureMessage
    ) {
        $this->assertMatcherFailureMessage(
            '? throws ?',
            array($method, $expectedException),
            $failureMessage
        );
    }

    public function tags()
    {
        return array(Tag::EXCEPTIONS);
    }
}
