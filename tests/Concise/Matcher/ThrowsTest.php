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

	/**
	 * @dataProvider exceptionTests
	 */
	public function testExpectFailures(callable $method, $expectedException, $expectToThrow)
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
	 * @expectedException \Exception
	 * @expectedExcatpionMessage The attribute to test for exception must be callable (an anonymous function)
	 */
	public function testMatcherWillOnlyAcceptCallable()
	{
		$this->matcher->match('', array(123));
	}
}
