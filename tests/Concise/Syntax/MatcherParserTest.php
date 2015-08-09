<?php

namespace Concise\Syntax;

use Concise\Matcher\AbstractMatcher;
use Concise\Modules\Basic\Equals;
use Concise\TestCase;

class MyBadMatcher extends AbstractMatcher
{
    public function match($syntax, array $data = array())
    {
        return false;
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
        $matcher = MatcherParser::getInstance()
            ->compile('x equals y', $this->getData());
        $this->assert($matcher, is_instance_of, '\Concise\Assertion');
    }

    public function testGetInstanceIsASingleton()
    {
        $this->assert(
            MatcherParser::getInstance(),
            exactly_equals,
            MatcherParser::getInstance()
        );
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
        $parser = $this->niceMock('\Concise\Syntax\MatcherParser')->expect(
            'getRawKeywords'
        )->once()->andReturn(array('a'))->get();

        $parser->getKeywords();
        $parser->getKeywords();
    }

    public function testGetAllSyntaxesContainsItemsFromDifferentMatchers()
    {
        $syntaxes = MatcherParser::getInstance()->getAllMatcherDescriptions();
        $this->assert(
            $syntaxes,
            has_keys,
            array('? is null', '? is equal to ?')
        );
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Argument 2 (123) must be regex.
     */
    public function testWillValidateAllAttributes()
    {
        $this->assert('"abc" does not match regex 123');
    }

    /**
     * @param string[] $supportedSyntaxes
     */
    protected function getAbstractMatcherMockWithSupportedSyntaxes(
        $supportedSyntaxes
    ) {
        return $this->mock('\Concise\Matcher\AbstractMatcher')->stub(
            array('supportedSyntaxes' => $supportedSyntaxes)
        )->get();
    }

    public function testOnIsAKeyword()
    {
        $parser = MatcherParser::getInstance();
        $this->assert($parser->getKeywords(), has_value, 'on');
    }

    public function testErrorIsAKeyword()
    {
        $parser = MatcherParser::getInstance();
        $this->assert($parser->getKeywords(), has_value, 'error');
    }

    public function testOnErrorIsReturnedWhenLocatingTheMatcher()
    {
        $parser = MatcherParser::getInstance();
        $matcher =
            $parser->getMatcherForSyntax('? equals ? on error ?', array(''));
        $this->assert($matcher, has_key, 'on_error');
    }

    public function testOnErrorIsNotReturnedIfNotInTheSyntax()
    {
        $parser = MatcherParser::getInstance();
        $matcher = $parser->getMatcherForSyntax('? equals ?', array());
        $this->assert($matcher, does_not_have_key, 'on_error');
    }

    public function testOnErrorIsReturnedFromData()
    {
        $parser = MatcherParser::getInstance();
        $matcher =
            $parser->getMatcherForSyntax('? equals ? on error ?', array('foo'));
        $this->assert($matcher['on_error'], equals, 'foo');
    }

    public function testOnErrorMustBeTheLastData()
    {
        $parser = MatcherParser::getInstance();
        $matcher = $parser->getMatcherForSyntax(
            '? equals ? on error ?',
            array('foo', 'bar')
        );
        $this->assert($matcher['on_error'], equals, 'bar');
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
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected string, but got integer for argument 1
     */
    public function testCompileSyntaxMustBeAString()
    {
        $parser = new MatcherParser();
        $parser->compile(123);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Argument 2 (null) must be regex.
     */
    public function testWillUseValueRendererForValuesInExceptionMessages()
    {
        $this->assert("abc", does_not_match_regex, null);
    }
}
