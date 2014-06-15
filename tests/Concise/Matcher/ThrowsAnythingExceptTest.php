<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class ThrowsAnythingExceptTest extends AbstractExceptionTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new ThrowsAnythingExcept();
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
			array($throwMyException,    $expectException,      $FAIL),
			array($throwMyException,    $expectMyException,    $PASS),
			array($throwMyException,    $expectOtherException, $FAIL),
			array($throwOtherException, $expectException,      $FAIL),
			array($throwOtherException, $expectMyException,    $FAIL),
		);
	}

	public function exceptionThrowsAnythingExceptTestMessages()
	{
		$expectException = 'Exception';
		$expectMyException = 'Concise\Matcher\MyException';
		$expectOtherException = 'Concise\Matcher\OtherException';
		$throwNothing = function() {};
		$throwException = function() { throw new \Exception(); };
		$throwMyException = function() { throw new \Concise\Matcher\MyException(); };
		$throwOtherException = function() { throw new \Concise\Matcher\OtherException(); };

		return array(
			array($throwException,   $expectException,   "Expected any exception except $expectException to be thrown, but $expectException was thrown."),
			array($throwMyException, $expectMyException, "Expected any exception except $expectMyException to be thrown, but $expectMyException was thrown."),
		);
	}

	/**
	 * @dataProvider exceptionTests
	 */
	public function testThrowsAnythingExcept(\Closure $method, $expectedException, $expectToThrow)
	{
		$didThrow = true;
		try {
			$this->matcher->match('? throws anything except ?', array($method, $expectedException));
			$didThrow = false;
		}
		catch(DidNotMatchException $e) {
		}
		$this->assertSame($expectToThrow, !$didThrow);
	}

	/**
	 * @dataProvider exceptionThrowsAnythingExceptTestMessages
	 */
	public function testThrowsAnythingExceptMessages(\Closure $method, $expectedException, $failureMessage)
	{
		$this->assertMatcherFailureMessage('? throws anything except ?', array($method, $expectedException), $failureMessage);
	}
	
}
