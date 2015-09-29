<?php

namespace Concise\Module;

use Closure;
use Concise\Core\DidNotMatchException;
use Exception;

class MyException extends Exception
{
}

class OtherException extends Exception
{
}

class ExceptionModuleTest extends AbstractModuleTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->module = new ExceptionModule();
    }

    protected function createExceptionTests(array $data)
    {
        $throw = array(
            'throwNothing' => function () {
            },
            'throwException' => function () {
                throw new Exception();
            },
            'throwMyException' => function () {
                throw new MyException();
            },
            'throwOtherException' => function () {
                throw new OtherException();
            },
        );
        $expect = array(
            'expectException' => 'Exception',
            'expectMyException' => 'Concise\Module\MyException',
            'expectOtherException' => 'Concise\Module\OtherException',
        );
        $result = array(
            'FAIL' => true,
            'PASS' => false,
        );

        $r = array();
        foreach ($data as $d) {
            if (array_key_exists($d[2], $result)) {
                $r[] = array($throw[$d[0]], $expect[$d[1]], $result[$d[2]]);
            } else {
                $r[] = array($throw[$d[0]], $expect[$d[1]], $d[2]);
            }
        }

        return $r;
    }

    public function exceptionTests()
    {
        $throwNothing = function () {
        };
        $throwException = function () {
            throw new \Exception();
        };

        return array(
            array($throwNothing, false),
            array($throwException, true),
        );
    }

    /**
     * @dataProvider exceptionTests
     */
    public function testDoesNotThrow(Closure $method, $expectSuccess)
    {
        $success = true;
        try {
            $this->assertClosure($method)->doesNotThrowException;
        } catch (DidNotMatchException $e) {
            $success = false;
        }
        $this->assert($expectSuccess)->equals(!$success);
    }

    public function testDoesNotThrowMessage()
    {
        try {
            $this->assertClosure(
                function () {
                    throw new \Exception();
                }
            )->doesNotThrowException;
            $this->fail("Exception was not thrown.");
        } catch (DidNotMatchException $e) {
            $this->assert("Expected exception not to be thrown.")->equals(
                $e->getMessage()
            );
        }
    }

    public function exceptionTests2()
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
                    'Expected Exception not to be thrown, but Concise\Module\MyException was thrown.'
                ),
                array(
                    'throwMyException',
                    'expectMyException',
                    'Expected Concise\Module\MyException not to be thrown, but Concise\Module\MyException was thrown.'
                ),
                array(
                    'throwOtherException',
                    'expectException',
                    'Expected Exception not to be thrown, but Concise\Module\OtherException was thrown.'
                ),
                array(
                    'throwOtherException',
                    'expectOtherException',
                    'Expected Concise\Module\OtherException not to be thrown, but Concise\Module\OtherException was thrown.'
                ),
            )
        );
    }

    /**
     * @dataProvider exceptionTests2
     */
    public function testDoesNotThrow2(
        Closure $method,
        $expectedException,
        $expectToThrow
    ) {
        if (!$expectToThrow) {
            $this->setExpectedException('\Concise\Core\DidNotMatchException');
        }
        $this->assertClosure($method)->doesNotThrow($expectedException);
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
            $failureMessage,
            'doesNotThrow'
        );
    }

    public function exceptionTests3()
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
                    'Expected any exception except Concise\Module\MyException to be thrown, but Concise\Module\MyException was thrown.'
                ),
            )
        );
    }

    /**
     * @dataProvider exceptionTests3
     */
    public function testThrowsAnythingExcept(
        Closure $method,
        $expectedException,
        $expectToThrow
    ) {
        try {
            $this->assertClosure($method)
                ->throwsAnythingExcept($expectedException);
            $didThrow = false;
        } catch (DidNotMatchException $e) {
            $didThrow = true;
        }
        $this->assert($expectToThrow)->doesNotEqual($didThrow);
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
            $failureMessage,
            'throwsAnythingExcept'
        );
    }

    public function exceptionTests4()
    {
        return $this->createExceptionTests(
            array(
//                array('throwNothing', 'expectException', 'FAIL'),
//                array('throwNothing', 'expectMyException', 'FAIL'),
                array('throwException', 'expectException', 'PASS'),
//                array('throwException', 'expectMyException', 'FAIL'),
//                array('throwMyException', 'expectException', 'FAIL'),
//                array('throwMyException', 'expectMyException', 'PASS'),
//                array('throwMyException', 'expectOtherException', 'FAIL'),
//                array('throwOtherException', 'expectException', 'FAIL'),
//                array('throwOtherException', 'expectMyException', 'FAIL'),
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
                    'Expected exactly Concise\Module\MyException to be thrown, but nothing was thrown.'
                ),
                array(
                    'throwException',
                    'expectMyException',
                    'Expected exactly Concise\Module\MyException to be thrown, but Exception was thrown.'
                ),
                array(
                    'throwMyException',
                    'expectException',
                    'Expected exactly Exception to be thrown, but Concise\Module\MyException was thrown.'
                ),
                array(
                    'throwMyException',
                    'expectOtherException',
                    'Expected exactly Concise\Module\OtherException to be thrown, but Concise\Module\MyException was thrown.'
                ),
                array(
                    'throwOtherException',
                    'expectException',
                    'Expected exactly Exception to be thrown, but Concise\Module\OtherException was thrown.'
                ),
                array(
                    'throwOtherException',
                    'expectMyException',
                    'Expected exactly Concise\Module\MyException to be thrown, but Concise\Module\OtherException was thrown.'
                ),
            )
        );
    }

    /**
     * @dataProvider exceptionTests4
     */
    public function testThrowsExactly(
        Closure $method,
        $expectedException,
        $expectToThrow
    ) {
        if ($expectToThrow) {
            $this->setExpectedException('\Concise\Core\DidNotMatchException');
        }

        $this->assertClosure($method)->throwsExactly($expectedException);
    }

    /**
     * @dataProvider exceptionThrowsExactlyTestMessages
     */
//    public function testThrowsExactlyMessages(
//        Closure $method,
//        $expectedException,
//        $failureMessage
//    ) {
//        $this->assertMatcherFailureMessage(
//            '? throws exactly ?',
//            array($method, $expectedException),
//            $failureMessage,
//            'throwsExactly'
//        );
//    }

    public function exceptionTests5()
    {
        $throwNothing = function () {
        };
        $throwException = function () {
            throw new Exception();
        };

        return array(
            array($throwNothing, false),
            array($throwException, true),
        );
    }

    /**
     * @dataProvider exceptionTests5
     */
    public function testThrows(Closure $method, $expectSuccess)
    {
        try {
            $this->assertClosure($method)->throwsException;
            $success = true;
        } catch (DidNotMatchException $e) {
            $success = false;
        }
        $this->assert($expectSuccess)->equals($success);
    }

    public function testThrowsMessage()
    {
        try {
            $this->assertClosure(
                function () {
                }
            )->throwsException;
            $this->fail("Exception was not thrown.");
        } catch (DidNotMatchException $e) {
            $this->assert("Expected exception to be thrown.")->equals(
                $e->getMessage()
            );
        }
    }

    public function exceptionTests6()
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
                    'Expected Concise\Module\MyException to be thrown, but nothing was thrown.'
                ),
                array(
                    'throwException',
                    'expectMyException',
                    'Expected Concise\Module\MyException to be thrown, but Exception was thrown.'
                ),
                array(
                    'throwMyException',
                    'expectOtherException',
                    'Expected Concise\Module\OtherException to be thrown, but Concise\Module\MyException was thrown.'
                ),
                array(
                    'throwOtherException',
                    'expectMyException',
                    'Expected Concise\Module\MyException to be thrown, but Concise\Module\OtherException was thrown.'
                ),
            )
        );
    }

    /**
     * @dataProvider exceptionTests6
     */
    public function testThrows2(
        Closure $method,
        $expectedException,
        $expectToThrow
    ) {
        if ($expectToThrow) {
            $this->setExpectedException('\Concise\Core\DidNotMatchException');
        }
        $this->assertClosure($method)->throws($expectedException);
    }

    /**
     * @dataProvider exceptionThrowsTestMessages
     */
    public function testThrowsMessages(
        Closure $method,
        $expectedException,
        $failureMessage
    ) {
        $this->assertMatcherFailureMessage(
            '? throws ?',
            array($method, $expectedException),
            $failureMessage,
            'throws'
        );
    }
}
