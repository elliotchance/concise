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

	public function _test_comparisons()
	{
		$this->doesThrow = function() {
			throw new MyException();
		};
		$this->doesThrowOther = function() {
			throw new OtherException();
		};
		return array(
			'doesThrow throws \Exception',
			'doesThrow throws \Concise\Matcher\MyException',
			'doesThrow does not throw \Concise\Matcher\OtherException',
		);
	}

	public function expectFailures()
	{
		return array(
			array(function() {}, '\Exception')
		);
	}

	/**
	 * @dataProvider expectFailures
	 */
	public function testExpectFailures(callable $method, $expectedException)
	{
		try {
			$this->matcher->match('? throws ?', array($method, $expectedException));
		}
		catch(DidNotMatchException $e) {
			$this->assertTrue(true);
			return;
		}
		$this->fail("Exception not thrown.");
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
