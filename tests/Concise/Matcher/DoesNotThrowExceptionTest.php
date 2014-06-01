<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class DoesNotThrowExceptionTest extends AbstractExceptionTestCase
{
	public function prepare()
	{
		parent::prepare();
		$this->matcher = new DoesNotThrowException();
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
	public function testDoesNotThrow(\Closure $method, $expectSuccess)
	{
		$success = false;
		try {
			$success = $this->matcher->match('? does not throw exception', array($method));
		}
		catch(DidNotMatchException $e) {
		}
		$this->assertSame($expectSuccess, !$success);
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
	
}
