<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class ThrowsExactlyTest extends AbstractExceptionTestCase
{

	public function prepare()
	{
		parent::prepare();
		$this->matcher = new ThrowsExactly();
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

	public function exceptionThrowsExactlyTestMessages()
	{
		$expectException = 'Exception';
		$expectMyException = 'Concise\Matcher\MyException';
		$expectOtherException = 'Concise\Matcher\OtherException';
		$throwNothing = function() {};
		$throwException = function() { throw new \Exception(); };
		$throwMyException = function() { throw new \Concise\Matcher\MyException(); };
		$throwOtherException = function() { throw new \Concise\Matcher\OtherException(); };

		return array(
			array($throwNothing,        $expectException,      "Expected exactly $expectException to be thrown, but nothing was thrown."),
			array($throwNothing,        $expectMyException,    "Expected exactly $expectMyException to be thrown, but nothing was thrown."),
			array($throwException,      $expectMyException,    "Expected exactly $expectMyException to be thrown, but $expectException was thrown."),
			array($throwMyException,    $expectException,      "Expected exactly $expectException to be thrown, but $expectMyException was thrown."),
			array($throwMyException,    $expectOtherException, "Expected exactly $expectOtherException to be thrown, but $expectMyException was thrown."),
			array($throwOtherException, $expectException,      "Expected exactly $expectException to be thrown, but $expectOtherException was thrown."),
			array($throwOtherException, $expectMyException,    "Expected exactly $expectMyException to be thrown, but $expectOtherException was thrown."),
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
			array($throwException,   $expectException,   "Expected any exception except $expectException not to be thrown, but $expectException was thrown."),
			array($throwMyException, $expectMyException, "Expected any exception except $expectMyException not to be thrown, but $expectMyException was thrown."),
		);
	}

	/**
	 * @dataProvider exceptionTests
	 */
	public function testThrowsExactly(\Closure $method, $expectedException, $expectToThrow)
	{
		$didThrow = true;
		try {
			$this->matcher->match('? throws exactly ?', array($method, $expectedException));
			$didThrow = false;
		}
		catch(DidNotMatchException $e) {
		}
		$this->assertSame($expectToThrow, $didThrow);
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
	 * @dataProvider exceptionThrowsExactlyTestMessages
	 */
	public function testThrowsExactlyMessages(\Closure $method, $expectedException, $failureMessage)
	{
		try {
			$this->matcher->match('? throws exactly ?', array($method, $expectedException));
			$this->fail("Exception was not thrown.");
		}
		catch(DidNotMatchException $e) {
			$this->assertEquals($failureMessage, $e->getMessage());
		}
	}

	/**
	 * @dataProvider exceptionThrowsAnythingExceptTestMessages
	 */
	/*public function testThrowsAnythingExceptMessages(\Closure $method, $expectedException, $failureMessage)
	{
		try {
			$this->matcher->match('? throws anything except ?', array($method, $expectedException));
			$this->fail("Exception was not thrown.");
		}
		catch(DidNotMatchException $e) {
			$this->assertEquals($failureMessage, $e->getMessage());
		}
	}*/
	
}
