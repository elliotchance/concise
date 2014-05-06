<?php

namespace Concise;

class MatcherParserTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->parser = new MatcherParser();
	}

	public function testMatcherParserCanResolveMatcherForSyntax()
	{
		$matcher = $this->parser->compile('a equals b');
		$this->assertInstanceOf('\Concise\Matcher\EqualTo', $matcher);
	}

	public function testTranslateAssertionIntoSyntax()
	{
		$syntax = $this->parser->translateAssertionToSyntax('a equals b');
		$this->assertEquals('? equals ?', $syntax);
	}

	public function testMatcherIsRegisteredReturnsFalseIfClassIsNotRegistered()
	{
		$this->assertFalse($this->parser->matcherIsRegistered('\No\Such\Class'));
	}

	public function testRegisteringANewMatcherReturnsTrue()
	{
		$this->assertTrue($this->parser->registerMatcher(new Matcher\EqualTo()));
	}

	public function testRegisteringAnExistingMatcherReturnsFalse()
	{
		$matcher = new Matcher\EqualTo();
		$this->parser->registerMatcher($matcher);
		$this->assertFalse($this->parser->registerMatcher($matcher));
	}
}
