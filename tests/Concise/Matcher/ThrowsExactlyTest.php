<?php

namespace Concise\Matcher;

/**
 * @group matcher
 */
class ThrowsExactlyTest extends AbstractExceptionTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new ThrowsExactly();
    }

    public function exceptionTests()
    {
        return $this->createExceptionTests(
            array(
                array('throwNothing', 'expectException', 'FAIL'),
                array('throwNothing', 'expectMyException', 'FAIL'),
                array('throwException', 'expectException', 'PASS'),
                array('throwException', 'expectMyException', 'FAIL'),
                array('throwMyException', 'expectException', 'FAIL'),
                array('throwMyException', 'expectMyException', 'PASS'),
                array('throwMyException', 'expectOtherException', 'FAIL'),
                array('throwOtherException', 'expectException', 'FAIL'),
                array('throwOtherException', 'expectMyException', 'FAIL'),
            )
        );
    }

    public function exceptionThrowsExactlyTestMessages()
    {
        return $this->createExceptionTests(
            array(
                array(
                    'throwNothing',
                    'expectException',
                    "Expected exactly Exception to be thrown, but nothing was thrown."
                ),
                array(
                    'throwNothing',
                    'expectMyException',
                    "Expected exactly Concise\Matcher\MyException to be thrown, but nothing was thrown."
                ),
                array(
                    'throwException',
                    'expectMyException',
                    "Expected exactly Concise\Matcher\MyException to be thrown, but Exception was thrown."
                ),
                array(
                    'throwMyException',
                    'expectException',
                    "Expected exactly Exception to be thrown, but Concise\Matcher\MyException was thrown."
                ),
                array(
                    'throwMyException',
                    'expectOtherException',
                    "Expected exactly Concise\Matcher\OtherException to be thrown, but Concise\Matcher\MyException was thrown."
                ),
                array(
                    'throwOtherException',
                    'expectException',
                    "Expected exactly Exception to be thrown, but Concise\Matcher\OtherException was thrown."
                ),
                array(
                    'throwOtherException',
                    'expectMyException',
                    "Expected exactly Concise\Matcher\MyException to be thrown, but Concise\Matcher\OtherException was thrown."
                ),
            )
        );
    }

    /**
     * @dataProvider exceptionTests
     */
    public function testThrowsExactly(
        \Closure $method,
        $expectedException,
        $expectToThrow
    ) {
        if ($expectToThrow) {
            $this->assertMatcherFailure(
                '? throws exactly ?',
                array($method, $expectedException)
            );
        } else {
            $this->assertMatcherSuccess(
                '? throws exactly ?',
                array($method, $expectedException)
            );
        }
    }

    /**
     * @dataProvider exceptionThrowsExactlyTestMessages
     */
    public function testThrowsExactlyMessages(
        \Closure $method,
        $expectedException,
        $failureMessage
    ) {
        $this->assertMatcherFailureMessage(
            '? throws exactly ?',
            array($method, $expectedException),
            $failureMessage
        );
    }

    public function tags()
    {
        return array(Tag::EXCEPTIONS);
    }
}
