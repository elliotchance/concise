<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class EqualToTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new EqualTo();
	}

	public function _test_comparisons()
	{
		return array(
			'123 equals 123',
			'123 equals 123.0',
			'123 equals "123"'
		);
	}

	public function failedMessages()
	{
		return array(
			array('? equals ?', array(false, true), 'bad')
		);
	}

	// @test can name assertions with an assoc array when returning from method

	// @test warn if attributes are set and not used

	// @test must must setup and tear down when generating the data source for test
}
