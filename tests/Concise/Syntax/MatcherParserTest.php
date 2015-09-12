<?php

namespace Concise\Syntax;

use Concise\Module\AbstractModule;
use Concise\TestCase;

class MyBadMatcher extends AbstractModule
{
    public function match()
    {
        return false;
    }

    public function getName()
    {
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

    public function testGetInstanceIsASingleton()
    {
        /*$this->assert(
            MatcherParser::getInstance(),
            exactly_equals,
            MatcherParser::getInstance()
        );*/
        $this->assert(MatcherParser::getInstance())->exactlyEquals(MatcherParser::getInstance());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage No such matcher for syntax 'something'.
     */
    public function testGetMatcherForSyntaxThrowsExceptionIfNoMatchersAreFound()
    {
        $this->parser->getMatcherForSyntax('something');
    }

    public function testGetAllKeywordsReturnsAnArray()
    {
        $keywords = MatcherParser::getInstance()->getKeywords();
        /*$this->assert($keywords, is_an_array);*/
        $this->assert($keywords)->isAnArray;
    }

    public function testGetAllKeywordsContainsKeywordsFromMatchers()
    {
        $keywords = MatcherParser::getInstance()->getKeywords();
        /*$this->assert($keywords, has_value, 'not');*/
        $this->assert($keywords)->hasValue('not');
    }

    public function testGetAllKeywordsContainsOnlyUniqueWords()
    {
        $keywords = MatcherParser::getInstance()->getKeywords();
        /*$this->assert($keywords, is_unique);*/
        $this->assert($keywords)->isUnique;
    }

    public function testGetAllKeywordsDoesNotContainPlaceholders()
    {
        $keywords = MatcherParser::getInstance()->getKeywords();
        /*$this->assert($keywords, does_not_have_value, '?');*/
        $this->assert($keywords)->doesNotHaveValue('?');
    }

    public function testGetAllKeywordsAreSorted()
    {
        $keywords1 = MatcherParser::getInstance()->getKeywords();
        $keywords2 = MatcherParser::getInstance()->getKeywords();
        sort($keywords2);
        /*$this->assert($keywords1, equals, $keywords2);*/
        $this->assert($keywords1)->equals($keywords2);
    }

    public function testGetKeywordsAreOnlyGeneratedOnce()
    {
        $parser = $this->niceMock('\Concise\Syntax\MatcherParser')->expect(
            'getRawKeywords'
        )->once()->andReturn(array('a'))->get();

        $parser->getKeywords();
        $parser->getKeywords();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Argument 2 (123) must be regex.
     */
    public function testWillValidateAllAttributes()
    {
        $this->assert("abc")->doesNotMatchRegex(123);
    }

    /**
     * @param string[] $supportedSyntaxes
     * @return AbstractModule
     */
    protected function getAbstractMatcherMockWithSupportedSyntaxes(
        $supportedSyntaxes
    ) {
        return $this->mock('\Concise\Module\AbstractModule')->stub(
            array('supportedSyntaxes' => $supportedSyntaxes)
        )->get();
    }

    public function testOnIsAKeyword()
    {
        $parser = MatcherParser::getInstance();
        /*$this->assert($parser->getKeywords(), has_value, 'on');*/
        $this->assert($parser->getKeywords())->hasValue('on');
    }

    public function testErrorIsAKeyword()
    {
        $parser = MatcherParser::getInstance();
        /*$this->assert($parser->getKeywords(), has_value, 'error');*/
        $this->assert($parser->getKeywords())->hasValue('error');
    }

    public function testOnErrorIsReturnedWhenLocatingTheMatcher()
    {
        $parser = MatcherParser::getInstance();
        $matcher =
            $parser->getMatcherForSyntax('? equals ? on error ?', array(''));
        /*$this->assert($matcher, has_key, 'on_error');*/
        $this->assert($matcher)->hasKey('on_error');
    }

    public function testOnErrorIsNotReturnedIfNotInTheSyntax()
    {
        $parser = MatcherParser::getInstance();
        $matcher = $parser->getMatcherForSyntax('? equals ?', array());
        /*$this->assert($matcher, does_not_have_key, 'on_error');*/
        $this->assert($matcher)->doesNotHaveKey('on_error');
    }

    public function testOnErrorIsReturnedFromData()
    {
        $parser = MatcherParser::getInstance();
        $matcher =
            $parser->getMatcherForSyntax('? equals ? on error ?', array('foo'));
        /*$this->assert($matcher['on_error'], equals, 'foo');*/
        $this->assert($matcher['on_error'])->equals('foo');
    }

    public function testOnErrorMustBeTheLastData()
    {
        $parser = MatcherParser::getInstance();
        $matcher = $parser->getMatcherForSyntax(
            '? equals ? on error ?',
            array('foo', 'bar')
        );
        /*$this->assert($matcher['on_error'], equals, 'bar');*/
        $this->assert($matcher['on_error'])->equals('bar');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected string, but got integer for argument 1
     */
    public function testSyntaxMustBeAString()
    {
        $parser = new MatcherParser();
        $parser->getMatcherForSyntax(123);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Argument 2 (null) must be regex.
     */
    public function testWillUseValueRendererForValuesInExceptionMessages()
    {
        /*$this->assert("abc", does_not_match_regex, null);*/
        $this->assert("abc")->doesNotMatchRegex(null);
    }

    public function testGetModules()
    {
        /*$this->assert($this->parser->getModules(), is_an_array);*/
        $this->assert($this->parser->getModules())->isAnArray;
    }
}
