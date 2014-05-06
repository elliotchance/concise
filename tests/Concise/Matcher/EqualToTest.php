<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class EqualToTest extends TestCase
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
}
