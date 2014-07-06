<?php

namespace Concise\Syntax;

use \Concise\TestCase;
use \Concise\Services\MatcherSyntaxAndDescription;

class MatcherParserStub extends MatcherParser
{
	public function registerMatchers()
	{
		return parent::registerMatchers();
	}
}

class MatcherParserTest extends TestCase
{
	/** @var MatcherParser */
	protected $parser;

	public function setUp()
	{
		parent::setUp();
		$this->parser = new MatcherParser();
	}

	public function testCompileReturnsAssertion()
	{
		$this->parser->registerMatcher(new \Concise\Matcher\Equals());
		$matcher = $this->parser->compile('x equals y', $this->getData());
		$this->assert($matcher, is_instance_of, '\Concise\Assertion');
	}

	public function testMatcherIsRegisteredReturnsFalseIfClassIsNotRegistered()
	{
		$this->assert($this->parser->matcherIsRegistered('\No\Such\Class'), is_false);
	}

	public function testRegisteringANewMatcherReturnsTrue()
	{
		$this->assert($this->parser->registerMatcher(new \Concise\Matcher\Equals()));
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Ambiguous syntax for 'something'.
	 */
	public function testThatOnlyOneMatcherCanRespondToASyntax()
	{
		$matcher = $this->niceMock('\Concise\Matcher\AbstractMatcher')
		                ->expect('supportedSyntaxes')->andReturn(array('something'));

		$this->parser->registerMatcher($matcher->done());
		$this->parser->registerMatcher($matcher->done());

		$this->parser->getMatcherForSyntax('something');
	}

	public function testGetInstanceIsASingleton()
	{
		$this->assert(MatcherParser::getInstance(), exactly_equals, MatcherParser::getInstance());
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
		$keywords = MatcherParser::getInstance()->getKeywords();
		$this->assertTrue(is_array($keywords));
	}

	public function testGetAllKeywordsContainsKeywordsFromMatchers()
	{
		$keywords = MatcherParser::getInstance()->getKeywords();
		$this->assertContains('not', $keywords);
	}

	public function testGetAllKeywordsContainsOnlyUniqueWords()
	{
		$keywords = MatcherParser::getInstance()->getKeywords();
		$this->assertEquals(count($keywords), count(array_unique($keywords)));
	}

	public function testGetAllKeywordsDoesNotContainPlaceholders()
	{
		$keywords = MatcherParser::getInstance()->getKeywords();
		$this->assertNotContains('?', $keywords);
	}

	public function testGetAllKeywordsAreSorted()
	{
		$keywords1 = MatcherParser::getInstance()->getKeywords();
		$keywords2 = MatcherParser::getInstance()->getKeywords();
		sort($keywords2);
		$this->assertEquals($keywords1, $keywords2);
	}

	public function testGetKeywordsAreOnlyGeneratedOnce()
	{
		$parser = $this->getMock('\Concise\Syntax\MatcherParser', array('getRawKeywords'));
		$parser->expects($this->once())
		       ->method('getRawKeywords')
		       ->will($this->returnValue(array('a')));

		$parser->getKeywords();
		$parser->getKeywords();
	}

	/**
	 * @param string[] $needles
	 */
	protected function assertArrayContains($needles,  $haystack)
	{
		foreach($needles as $needle) {
			$this->assertContains($needle, $haystack);
		}
	}

	public function testGetAllSyntaxesContainsItemsFromDifferentMatchers()
	{
		$syntaxes = MatcherParser::getInstance()->getAllSyntaxes();
		$this->assertArrayContains(array(
			'? is null'       => 'Assert a value is null.',
			'? is equal to ?' => 'Assert values with no regard to exact data types.',
		), $syntaxes);
	}

	public function testCanMatchSyntaxWithExpectedTypes()
	{
		$matcher = $this->getAbstractMatcherMockWithSupportedSyntaxes(array('?:int foobar ?:float'));
		$this->parser->registerMatcher($matcher);
		$assertion = $this->parser->compile('123 foobar 1.23', array());
		$this->assertSame($matcher, $assertion->getMatcher());
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Argument 2 (123) must be regex.
	 */
	public function testWillValidateAllAttributes()
	{
		$this->assert('"abc" does not match regex 123');
	}

	public function testAnythingThatStartsWithAQuestionMarkWillNotBeConsideredAKeyword()
	{
		$matcher = $this->getAbstractMatcherMockWithSupportedSyntaxes(array('?:int foobar ?:float'));
		$this->parser->registerMatcher($matcher);
		$this->assertEquals(array('foobar'), $this->parser->getKeywords());
	}

	/**
	 * @param string[] $supportedSyntaxes
	 */
	protected function getAbstractMatcherMockWithSupportedSyntaxes($supportedSyntaxes)
	{
		$matcher = $this->getMockForAbstractClass('\Concise\Matcher\AbstractMatcher');
		$matcher->expects($this->any())
		        ->method('supportedSyntaxes')
		        ->will($this->returnValue($supportedSyntaxes));
		return $matcher;
	}

	public function testKeywordCacheIsDroppedWhenAMatcherIsAdded()
	{
		$matcher1 = $this->getAbstractMatcherMockWithSupportedSyntaxes(array('foo'));
		$matcher2 = $this->getAbstractMatcherMockWithSupportedSyntaxes(array('bar'));
		$this->parser->registerMatcher($matcher1);
		$keywords1 = $this->parser->getKeywords();
		$this->parser->registerMatcher($matcher2);
		$keywords2 = $this->parser->getKeywords();
		$this->assertNotEquals($keywords1, $keywords2);
	}

	public function testSupportedSyntaxesAreUnique()
	{
		$rawSyntaxes = MatcherParser::getInstance()->getAllSyntaxes();
		$service = new MatcherSyntaxAndDescription();
		$syntaxes = array_keys($service->process($rawSyntaxes));
		$this->assert($syntaxes, is_unique);
	}
}
