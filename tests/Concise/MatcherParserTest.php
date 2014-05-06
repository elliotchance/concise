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
}
