<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class NullTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new Null();
	}

	public function syntaxProvider()
	{
		return array(
			array('? is null'),
			array('? is not null')
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
		$this->x = null;
		$this->y = 'a';
		return array(
			'x is null',
			'y is not null',
			'"null" is not null'
		);
	}
}
