<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class DoesNotThrowTest extends AbstractExceptionTestCase
{

	public function prepare()
	{
		parent::prepare();
		$this->matcher = new DoesNotThrow();
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
	 * @dataProvider exceptionDoesNotThrowTestMessages
	 */
	public function testDoesNotThrowMessages(\Closure $method, $expectedException, $failureMessage)
	{
		$this->assertMatcherFailureMessage('? does not throw ?', array($method, $expectedException), $failureMessage);
	}
	
}
