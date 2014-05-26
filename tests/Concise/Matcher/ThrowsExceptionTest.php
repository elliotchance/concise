<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class ThrowsExceptionTest extends AbstractMatcherTestCase
{
	public function prepare()
	{
		parent::prepare();
		$this->matcher = new ThrowsException();
	}

	public function exceptionTests()
	{
		$throwNothing = function() {};
		$throwException = function() { throw new \Exception(); };

		return array(
			array($throwNothing,   false),
			array($throwException, true),
		);
	}

	/**
	 * @dataProvider exceptionTests
	 */
	public function testThrows(callable $method, $expectSuccess)
	{
		$success = false;
		try {
			$this->matcher->match('? throws exception', array($method));
			$success = true;
		}
		catch(DidNotMatchException $e) {
		}
		$this->assertSame($expectSuccess, $success);
	}

	/**
	 * @dataProvider exceptionTests
	 */
	public function testDoesNotThrow(callable $method, $expectSuccess)
	{
		$success = false;
		try {
			$success = $this->matcher->match('? does not throw exception', array($method));
		}
		catch(DidNotMatchException $e) {
		}
		$this->assertSame($expectSuccess, !$success);
	}

	public function testThrowsMessage()
	{
		try {
			$this->matcher->match('? throws exception', array(function() {}));
			$this->fail("Exception was not thrown.");
		}
		catch(DidNotMatchException $e) {
			$this->assertEquals("Expected exception to be thrown.", $e->getMessage());
		}
	}

	public function testDoesNotThrowMessage()
	{
		try {
			$this->matcher->match('? does not throw exception', array(function() { throw new \Exception(); }));
			$this->fail("Exception was not thrown.");
		}
		catch(DidNotMatchException $e) {
			$this->assertEquals("Expected exception not to be thrown.", $e->getMessage());
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
