<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class MyException extends \Exception
{
}

class OtherException extends \Exception
{
}

class ThrowsTest extends AbstractMatcherTestCase
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
	public function testThrows(callable $method, $expectedException, $expectToThrow)
	{
		$didThrow = true;
		try {
			$this->matcher->match('? throws ?', array($method, $expectedException));
			$didThrow = false;
		}
		catch(DidNotMatchException $e) {
		}
		$this->assertSame($expectToThrow, $didThrow);
	}

	/**
	 * @dataProvider exceptionTests
	 */
	public function testDoesNotThrow(callable $method, $expectedException, $expectToThrow)
	{
		$didThrow = true;
		try {
			$this->matcher->match('? does not throw ?', array($method, $expectedException));
			$didThrow = false;
		}
		catch(DidNotMatchException $e) {
		}
		$this->assertSame($expectToThrow, !$didThrow);
	}

	/**
	 * @dataProvider exceptionThrowsTestMessages
	 */
	public function testThrowsMessages(callable $method, $expectedException, $failureMessage)
	{
		try {
			$this->matcher->match('? throws ?', array($method, $expectedException));
			$this->fail("Exception was not thrown.");
		}
		catch(DidNotMatchException $e) {
			$this->assertEquals($failureMessage, $e->getMessage());
		}
	}

	/**
	 * @dataProvider exceptionDoesNotThrowTestMessages
	 */
	public function testDoesNotThrowMessages(callable $method, $expectedException, $failureMessage)
	{
		try {
			$this->matcher->match('? does not throw ?', array($method, $expectedException));
			$this->fail("Exception was not thrown.");
		}
		catch(DidNotMatchException $e) {
			$this->assertEquals($failureMessage, $e->getMessage());
		}
	}

	/**
	 * @expectedException \Exception
	 * @expectedExcatpionMessage The attribute to test for exception must be callable (an anonymous function)
	 */
	public function testMatcherWillOnlyAcceptCallable()
	{
		$this->matcher->match('', array(123));
	}
}
