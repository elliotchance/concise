<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class AbstractMatcher extends TestCase
{
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
}
