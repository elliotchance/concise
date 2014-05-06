<?php

namespace Concise;

class MatcherParserTest extends TestCase
{
	public function testMatcherParserCanResolveMatcherForSyntax()
	{
		$parser = new MatcherParser();
		$matcher = $parser->compile('a equals b');
		$this->assertInstanceOf('\Concise\Matcher\EqualTo', $matcher);
	}

	public function testTranslateAssertionIntoSyntax()
	{
		$parser = new MatcherParser();
		$syntax = $parser->translateAssertionToSyntax('a equals b');
		$this->assertEquals('? equals ?', $syntax);
	}

	public function testMatcherIsRegisteredReturnsFalseIfClassIsNotRegistered()
	{
		$parser = new MatcherParser();
		$this->assertFalse($parser->matcherIsRegistered('\No\Such\Class'));
	}
}
