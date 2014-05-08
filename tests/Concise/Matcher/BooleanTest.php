<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class BooleanTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new Boolean();
	}

	public function _test_comparisons()
	{
		$this->a = true;
		$this->b = false;
		return array(
			'true',
			'a is true',
			'b is false'
		);
	}

	public function failedMessages()
	{
		return array(
			array('false', array(), 'Failed'),
			array('? is true', array(false), 'Value is not true.'),
			array('? is false', array(true), 'Value is not false.'),
		);
	}

	/**
	 * @dataProvider failedMessages
	 */
	public function testFailedMessageForFalse($syntax, $args, $message)
	{
		$this->assertEquals($message, $this->matcher->match($syntax, $args));
	}
}
