<?php

namespace Concise\Modules\Exceptions;

use Closure;
use Concise\Matcher\DidNotMatchException;

/**
 * @group matcher
 */
class ThrowsAnythingExceptTest extends AbstractExceptionTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new ThrowsAnythingExcept();
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

    public function exceptionThrowsAnythingExceptTestMessages()
    {
        return $this->createExceptionTests(
            array(
                array(
                    'throwException',
                    'expectException',
                    'Expected any exception except Exception to be thrown, but Exception was thrown.'
                ),
                array(
                    'throwMyException',
                    'expectMyException',
                    'Expected any exception except Concise\Modules\Exceptions\MyException to be thrown, but Concise\Modules\Exceptions\MyException was thrown.'
                ),
            )
        );
    }

    /**
     * @dataProvider exceptionTests
     */
    public function testThrowsAnythingExcept(
        Closure $method,
        $expectedException,
        $expectToThrow
    ) {
        try {
            $this->matcher->match(
                '? throws anything except ?',
                array($method, $expectedException)
            );
            $didThrow = false;
        } catch (DidNotMatchException $e) {
            $didThrow = true;
        }
        $this->assert($expectToThrow, equals, !$didThrow);
    }

    /**
     * @dataProvider exceptionThrowsAnythingExceptTestMessages
     */
    public function testThrowsAnythingExceptMessages(
        Closure $method,
        $expectedException,
        $failureMessage
    ) {
        $this->assertMatcherFailureMessage(
            '? throws anything except ?',
            array($method, $expectedException),
            $failureMessage
        );
    }
}
