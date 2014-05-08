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

	public function testMatcherIsRegisteredReturnsFalseIfClassIsNotRegistered()
	{
		$this->assertFalse($this->parser->matcherIsRegistered('\No\Such\Class'));
	}

	public function testRegisteringANewMatcherReturnsTrue()
	{
		$this->assertTrue($this->parser->registerMatcher(new Matcher\EqualTo()));
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Ambiguous syntax for 'something'.
	 */
	public function testThatOnlyOneMatcherCanRespondToASyntax()
	{
		$matcher1 = $this->getMockForAbstractClass('\Concise\Matcher\AbstractMatcher');
		$matcher1->expects($this->once())
		         ->method('supportedSyntaxes')
		         ->will($this->returnValue(array('something')));

		$matcher2 = $this->getMockForAbstractClass('\Concise\Matcher\AbstractMatcher');
		$matcher2->expects($this->once())
		         ->method('supportedSyntaxes')
		         ->will($this->returnValue(array('something')));

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

	public function testRegisterMatchersMustRegisterAtLeastOneMatcher()
	{
		$parser = new MatcherParserStub();
		$parser->registerMatchers();
		$this->assertGreaterThan(0, $parser->getMatchers());
	}

	public function testGetAllKeywordsReturnsAnArray()
	{
		$keywords = $this->parser->getKeywords();
		$this->assertTrue(is_array($keywords));
	}
}
