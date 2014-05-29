<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class ThrowsTest extends AbstractExceptionTestCase
{

	public function prepare()
	{
		parent::prepare();
		$this->matcher = new Throws();
	}

	public function exceptionTests()
	{
		$expectException = 'Exception';
		$expectMyException = 'Concise\Matcher\MyException';
		$expectOtherException = 'Concise\Matcher\OtherException';
		$throwNothing = function() {};
		$throwException = function() { throw new \Exception(); };
		$throwMyException = function() { throw new \Concise\Matcher\MyException(); };
		$throwOtherException = function() { throw new \Concise\Matcher\OtherException(); };
		$FAIL = true;
		$PASS = false;

		return array(
			array($throwNothing,        $expectException,      $FAIL),
			array($throwNothing,        $expectMyException,    $FAIL),
			array($throwException,      $expectException,      $PASS),
			array($throwException,      $expectMyException,    $FAIL),
			array($throwMyException,    $expectException,      $PASS),
			array($throwMyException,    $expectMyException,    $PASS),
			array($throwMyException,    $expectOtherException, $FAIL),
			array($throwOtherException, $expectException,      $PASS),
			array($throwOtherException, $expectMyException,    $FAIL),
			array($throwOtherException, $expectOtherException, $PASS),
		);
	}

	public function exceptionThrowsTestMessages()
	{
		$expectException = 'Exception';
		$expectMyException = 'Concise\Matcher\MyException';
		$expectOtherException = 'Concise\Matcher\OtherException';
		$throwNothing = function() {};
		$throwException = function() { throw new \Exception(); };
		$throwMyException = function() { throw new \Concise\Matcher\MyException(); };
		$throwOtherException = function() { throw new \Concise\Matcher\OtherException(); };

		return array(
			array($throwNothing,        $expectException,      "Expected $expectException to be thrown, but nothing was thrown."),
			array($throwNothing,        $expectMyException,    "Expected $expectMyException to be thrown, but nothing was thrown."),
			array($throwException,      $expectMyException,    "Expected $expectMyException to be thrown, but $expectException was thrown."),
			array($throwMyException,    $expectOtherException, "Expected $expectOtherException to be thrown, but $expectMyException was thrown."),
			array($throwOtherException, $expectMyException,    "Expected $expectMyException to be thrown, but $expectOtherException was thrown."),
		);
	}

	public function exceptionDoesNotThrowTestMessages()
	{
		$expectException = 'Exception';
		$expectMyException = 'Concise\Matcher\MyException';
		$expectOtherException = 'Concise\Matcher\OtherException';
		$throwNothing = function() {};
		$throwException = function() { throw new \Exception(); };
		$throwMyException = function() { throw new \Concise\Matcher\MyException(); };
		$throwOtherException = function() { throw new \Concise\Matcher\OtherException(); };

		return array(
			array($throwException,      $expectException,      "Expected $expectException not to be thrown, but $expectException was thrown."),
			array($throwMyException,    $expectException,      "Expected $expectException not to be thrown, but $expectMyException was thrown."),
			array($throwMyException,    $expectMyException,    "Expected $expectMyException not to be thrown, but $expectMyException was thrown."),
			array($throwOtherException, $expectException,      "Expected $expectException not to be thrown, but $expectOtherException was thrown."),
			array($throwOtherException, $expectOtherException, "Expected $expectOtherException not to be thrown, but $expectOtherException was thrown."),
		);
	}

	/**
	 * @dataProvider exceptionTests
	 */
	public function testThrows(\Closure $method, $expectedException, $expectToThrow)
	{
		if($expectToThrow) {
			$this->assertMatcherFailure('? throws ?', array($method, $expectedException));
		}
		else {
			$this->assertMatcherSuccess('? throws ?', array($method, $expectedException));
		}
	}

	/**
	 * @dataProvider exceptionTests
	 */
	public function testDoesNotThrow(\Closure $method, $expectedException, $expectToThrow)
	{
		if($expectToThrow) {
			$this->assertMatcherSuccess('? does not throw ?', array($method, $expectedException));
		}
		else {
			$this->assertMatcherFailure('? does not throw ?', array($method, $expectedException));
		}
	}

	/**
	 * @dataProvider exceptionThrowsTestMessages
	 */
	public function testThrowsMessages(\Closure $method, $expectedException, $failureMessage)
	{
		$this->assertMatcherFailureMessage('? throws ?', array($method, $expectedException), $failureMessage);
	}

	/**
	 * @dataProvider exceptionDoesNotThrowTestMessages
	 */
	public function testDoesNotThrowMessages(\Closure $method, $expectedException, $failureMessage)
	{
		$this->assertMatcherFailureMessage('? does not throw ?', array($method, $expectedException), $failureMessage);
	}
	
}
