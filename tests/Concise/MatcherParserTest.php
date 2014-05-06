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

	public function testTranslateAssertionIntoSyntaxWillReplaceAnyNonKeywordsWithPlaceholder()
	{
		$syntax = $this->parser->translateAssertionToSyntax('a is equal to b');
		$this->assertEquals('? is equal to ?', $syntax);
	}

	public function testKeywordsReturnsArray()
	{
		$this->assertTrue(is_array($this->parser->getKeywords()));
	}

	public function testKeywordsAreUnique()
	{
		$keywords = $this->parser->getKeywords();
		$this->assertCount(count($keywords), array_unique($keywords));
	}

	public function testKeywordsAreSorted()
	{
		$keywords = $this->parser->getKeywords();
		$sortedKeywords = $this->parser->getKeywords();
		sort($sortedKeywords);
		$this->assertEquals($keywords, $sortedKeywords);
	}

	public function testCanExtractDataFromAssertion()
	{
		$this->a = 123;
		$this->b = '456';
		$matcher = $this->parser->compile('a equals b');
		$expected = array(
			'a' => 123,
			'b' => '456'
		);
		$this->assertEquals($expected, $matcher->getData());
	}
}
