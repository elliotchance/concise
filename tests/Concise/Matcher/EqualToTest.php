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

	public function testExtendsAbstractMatcher()
	{
		$this->assertInstanceOf('\Concise\Matcher\AbstractMatcher', $this->matcher);
	}

	public function testCanRegisterMatcher()
	{
		$parser = new \Concise\MatcherParser($this);
		$this->assertTrue($parser->registerMatcher($this->matcher));
	}

	public function testParserKnowsAboutMatcher()
	{
		$parser = new \Concise\MatcherParser($this);
		$parser->registerMatcher($this->matcher);
		$this->assertTrue($parser->matcherIsRegistered(get_class($this->matcher)));
	}

	public function _test_a_equals_b()
	{
		$this->a = 123;
		$this->b = 456;
	}
}
