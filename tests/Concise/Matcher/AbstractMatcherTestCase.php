<?php

namespace Concise\Matcher;

use \Concise\TestCase;
use \Concise\Syntax\MatcherParser;

class AbstractMatcherTestCase extends TestCase
{
	public function testExtendsAbstractMatcher()
	{
		$this->assertInstanceOf('\Concise\Matcher\AbstractMatcher', $this->matcher);
	}

	public function testCanRegisterMatcher()
	{
		$parser = new MatcherParser();
		$this->assertTrue($parser->registerMatcher($this->matcher));
	}

	public function testParserKnowsAboutMatcher()
	{
		$parser = MatcherParser::getInstance();
		$this->assertTrue($parser->matcherIsRegistered(get_class($this->matcher)));
	}

	public function testSupportedSyntaxesAreUnique()
	{
		$syntaxes = $this->matcher->supportedSyntaxes();
		$this->assertEquals(count($syntaxes), count(array_unique($syntaxes)));
	}
}
