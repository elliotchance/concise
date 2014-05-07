<?php

namespace Concise;

class MatcherParserStub extends MatcherParser
{
	public function registerMatchers()
	{
		return parent::registerMatchers();
	}
}

class MatcherParserTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->parser = new MatcherParser();
	}

	public function testCompileReturnsAssertion()
	{
		$this->parser->registerMatcher(new Matcher\EqualTo());
		$matcher = $this->parser->compile('a equals b', $this->getData());
		$this->assertInstanceOf('\Concise\Assertion', $matcher);
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

	public function testCanGetPlaceholdersForSyntax()
	{
		$this->assertEquals(array('b', 'a'), $this->parser->getPlaceholders('b equals a'));
	}

	public function testCanGetDataForPlaceholders()
	{
		$data = array(
			'a' => 123,
			'b' => 'abc'
		);
		$result = $this->parser->getDataForPlaceholders(array('b', 'a'), $data);
		$this->assertEquals(array('abc', 123), $result);
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage No such attribute 'foo'.
	 */
	public function testGetDataForPlaceholdersThrowsExceptionIfThereIsNoSuchAttribute()
	{
		$this->parser->getDataForPlaceholders(array('foo'), array());
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Ambiguous syntax for 'something'.
	 */
	public function testThatOnlyOneMatcherCanRespondToASyntax()
	{
		$matcher1 = $this->getMockForAbstractClass('\Concise\Matcher\AbstractMatcher');
		$matcher1->expects($this->once())
		         ->method('matchesSyntax')
		         ->will($this->returnValue(true));

		$matcher2 = $this->getMockForAbstractClass('\Concise\Matcher\AbstractMatcher');
		$matcher2->expects($this->once())
		         ->method('matchesSyntax')
		         ->will($this->returnValue(true));

		$this->parser->registerMatcher($matcher1);
		$this->parser->registerMatcher($matcher2);

		$this->parser->getMatcherForSyntax('something');
	}

	public function testGetInstanceIsASingleton()
	{
		$this->assertSame(MatcherParser::getInstance(), MatcherParser::getInstance());
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage No such matcher for syntax 'something'.
	 */
	public function testGetMatcherForSyntaxThrowsExceptionIfNoMatchersAreFound()
	{
		$this->parser->getMatcherForSyntax('something');
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage registerMatchers() can only be called once.
	 */
	public function testRegisterMatchersCanOnlyBeCalledOnce()
	{
		$parser = new MatcherParserStub();
		$parser->registerMatchers();
		$parser->registerMatchers();
	}
}
