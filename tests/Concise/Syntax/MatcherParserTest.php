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

	public function testRegisteringANewMatcherReturnsTrue()
	{
		$this->assert($this->parser->registerMatcher(new \Concise\Matcher\Equals()));
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
		$this->assert(count($parser->getMatchers()), greater_than, 0);
	}

	public function testGetAllKeywordsReturnsAnArray()
	{
		$keywords = MatcherParser::getInstance()->getKeywords();
		$this->assert($keywords, is_an_array);
	}

	public function testGetAllKeywordsContainsKeywordsFromMatchers()
	{
		$keywords = MatcherParser::getInstance()->getKeywords();
		$this->assert($keywords, has_value, 'not');
	}

	public function testGetAllKeywordsContainsOnlyUniqueWords()
	{
		$keywords = MatcherParser::getInstance()->getKeywords();
		$this->assert($keywords, is_unique);
	}

	public function testGetAllKeywordsDoesNotContainPlaceholders()
	{
		$keywords = MatcherParser::getInstance()->getKeywords();
		$this->assert($keywords, does_not_have_value, '?');
	}

	public function testGetAllKeywordsAreSorted()
	{
		$keywords1 = MatcherParser::getInstance()->getKeywords();
		$keywords2 = MatcherParser::getInstance()->getKeywords();
		sort($keywords2);
		$this->assert($keywords1, equals, $keywords2);
	}

	public function testGetKeywordsAreOnlyGeneratedOnce()
	{
		$parser = $this->niceMock('\Concise\Syntax\MatcherParser')
		               ->expect('getRawKeywords')->once()->andReturn(array('a'))
		               ->done();

		$parser->getKeywords();
		$parser->getKeywords();
	}

	public function testGetAllSyntaxesContainsItemsFromDifferentMatchers()
	{
		$syntaxes = MatcherParser::getInstance()->getAllSyntaxes();
		$this->assert($syntaxes, has_items, array(
			'? is null'       => 'Assert a value is null.',
			'? is equal to ?' => 'Assert values with no regard to exact data types.',
		));
	}

	public function testCanMatchSyntaxWithExpectedTypes()
	{
		$matcher = $this->getAbstractMatcherMockWithSupportedSyntaxes(array('?:int foobar ?:float'));
		$this->parser->registerMatcher($matcher);
		$assertion = $this->parser->compile('123 foobar 1.23', array());
		$this->assert($matcher, exactly_equals, $assertion->getMatcher());
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
		$this->assert($this->parser->getKeywords(), equals, array('foobar'));
	}

	/**
	 * @param string[] $supportedSyntaxes
	 */
	protected function getAbstractMatcherMockWithSupportedSyntaxes($supportedSyntaxes)
	{
		return $this->mock('\Concise\Matcher\AbstractMatcher')
		            ->stub(array('supportedSyntaxes' => $supportedSyntaxes))
		            ->done();
	}

	public function testKeywordCacheIsDroppedWhenAMatcherIsAdded()
	{
		$matcher1 = $this->getAbstractMatcherMockWithSupportedSyntaxes(array('foo'));
		$matcher2 = $this->getAbstractMatcherMockWithSupportedSyntaxes(array('bar'));
		$this->parser->registerMatcher($matcher1);
		$keywords1 = $this->parser->getKeywords();
		$this->parser->registerMatcher($matcher2);
		$keywords2 = $this->parser->getKeywords();
		$this->assert($keywords1, does_not_equal, $keywords2);
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Syntax 'foo' is already declared.
	 */
	public function testAddingAMatcherWithDuplicateSyntaxThrowsException()
	{
		$matcher1 = $this->getAbstractMatcherMockWithSupportedSyntaxes(array('foo'));
		$matcher2 = $this->getAbstractMatcherMockWithSupportedSyntaxes(array('foo'));
		$this->parser->registerMatcher($matcher1);
		$this->parser->registerMatcher($matcher2);
	}
}
