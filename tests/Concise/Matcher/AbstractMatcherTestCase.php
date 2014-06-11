<?php

namespace Concise\Matcher;

use \Concise\TestCase;
use \Concise\Syntax\MatcherParser;

class AbstractMatcherTestCase extends TestCase
{
	public function testExtendsAbstractMatcher()
	{
		$this->assert('`$self->matcher` is instance of \Concise\Matcher\AbstractMatcher');
	}

	public function testCanRegisterMatcher()
	{
		$parser = new MatcherParser();
		$this->assertTrue($parser->registerMatcher($this->matcher));
	}

	public function testParserKnowsAboutMatcher()
	{
		$parser = MatcherParser::getInstance();
		$this->assertTrue($parser->matcherIsRegistered(get_class($this->matcher)));
	}

	public function testSupportedSyntaxesAreUnique()
	{
		$syntaxes = $this->matcher->supportedSyntaxes();
		$this->assertEquals(count($syntaxes), count(array_unique($syntaxes)));
	}

	protected function createStdClassThatCanBeCastToString($value)
	{
		$mock = $this->getMock('\stdClass', array('__toString'));
		$mock->expects($this->any())
		     ->method('__toString')
		     ->will($this->returnValue($value));
		return $mock;
	}

	/**
	 * @param string $syntax
	 */
	protected function assertMatcherFailureMessage($syntax, array $args, $failureMessage)
	{
		try {
			$this->matcher->match($syntax, $args);
			$this->fail("Expected assertion to fail.");
		}
		catch(DidNotMatchException $e) {
			$this->assertSame($failureMessage, $e->getMessage());
		}
	}

	/**
	 * @param string $syntax
	 */
	protected function assertMatcherFailure($syntax, array $args = array())
	{
		try {
			$result = $this->matcher->match($syntax, $args);
			$this->assertFalse($result);
		}
		catch(DidNotMatchException $e) {
			$this->assertTrue(true);
		}
	}

	/**
	 * @param string $syntax
	 */
	protected function assertMatcherSuccess($syntax, array $args = array())
	{
		$this->assertTrue($this->matcher->match($syntax, $args));
	}
}
