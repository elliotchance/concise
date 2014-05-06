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

	public function testWillRespondToCorrectSyntax()
	{
		$this->assertTrue($this->matcher->matchesSyntax('? equals ?'));
	}

	public function testExtendsAbstractMatcher()
	{
		$this->assertInstanceOf('\Concise\Matcher\AbstractMatcher', $this->matcher);
	}

	public function testCanRegisterMatcher()
	{
		$parser = new \Concise\MatcherParser();
		$this->assertTrue($parser->registerMatcher($this->matcher));
	}

	public function testParserKnowsAboutMatcher()
	{
		$parser = new \Concise\MatcherParser();
		$parser->registerMatcher($this->matcher);
		$this->assertTrue($parser->matcherIsRegistered(get_class($this->matcher)));
	}
}
