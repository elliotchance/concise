<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class MyCustomException extends \Exception
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
			throw new MyCustomException();
		};
		return array(
			'doesThrow throws \Concise\Matcher\MyCustomException',
		);
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
