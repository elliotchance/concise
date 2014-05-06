<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class EqualToTest extends TestCase
{
	public function testWillRespondToCorrectSyntax()
	{
		$matcher = new EqualTo();
		$this->assertTrue($matcher->matchesSyntax('? equals ?'));
	}

	public function testExtendsAbstractMatcher()
	{
		$matcher = new EqualTo();
		$this->assertInstanceOf('\Concise\Matcher\AbstractMatcher', $matcher);
	}

	public function testParserKnowsAboutMatcher()
	{
		$parser = new \Concise\MatcherParser();
		$this->assertTrue($parser->matcherIsRegistered(get_class($this)));
	}
}
