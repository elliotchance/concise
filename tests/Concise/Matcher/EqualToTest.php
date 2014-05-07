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

	public function syntaxProvider()
	{
		return array(
			array('? equals ?'),
			array('? is equal to ?')
		);
	}

	/**
	 * @dataProvider syntaxProvider
	 */
	public function testWillRespondToCorrectSyntax($syntax)
	{
		$this->assertTrue($this->matcher->matchesSyntax($syntax));
	}

	public function _test_comparisons()
	{
		return array(
			'123 equals 123',
			'123 equals 123.0',
			'123 equals "123"'
		);
	}

	// @test can name assertions with an assoc array when returning from method

	// @test warn if attributes are set and not used

	// @test must must setup and tear down when generating the data source for test

	// @test TOKEN_INTEGER and TOKEN_FLOAT need to support negative numbers and scientific notation
}
