<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class AbstractMatcherTestCase extends TestCase
{
	public function testExtendsAbstractMatcher()
	{
		$this->assertInstanceOf('\Concise\Matcher\AbstractMatcher', $this->matcher);
	}

	public function testCanRegisterMatcher()
	{
		$parser = new \Concise\MatcherParser();
		$this->assertTrue($parser->registerMatcher($this->matcher));
	}

	public function testParserKnowsAboutMatcher()
	{
		$parser = \Concise\MatcherParser::getInstance();
		$this->assertTrue($parser->matcherIsRegistered(get_class($this->matcher)));
	}

	public function testSupportedSyntaxesAreUnique()
	{
		$syntaxes = $this->matcher->supportedSyntaxes();
		$this->assertEquals(count($syntaxes), count(array_unique($syntaxes)));
	}

	/**
	 * @dataProvider failedMessages
	 */
	public function testFailedMessages($syntax, $args, $message)
	{
		$this->assertEquals($message, $this->matcher->match($syntax, $args));
	}
}
