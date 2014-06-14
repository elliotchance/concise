<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class ExactlyEqualsTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new ExactlyEquals();
	}

	public function testExactlyEquals()
	{
		$this->assert('123 exactly equals 123');
	}

	public function failures()
	{
		return array(
			array('123 exactly equals 123.0'),
			array('123 exactly equals "123"'),
		);
	}

	/**
	 * @dataProvider failures
	 */
	public function testExactlyEqualsFailure($assertion)
	{
		$this->assertFailure($assertion);
	}
}
