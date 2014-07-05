<?php

namespace Concise\Matcher;

use \Concise\TestCase;
use \Concise\Syntax\MatcherParser;
use \Concise\Services\MatcherSyntaxAndDescription;

class AbstractMatcherTestCase extends TestCase
{
	public function testExtendsAbstractMatcher()
	{
		$this->assert($this->matcher, is_instance_of, '\Concise\Matcher\AbstractMatcher');
	}

	public function testCanRegisterMatcher()
	{
		$parser = new MatcherParser();
		$this->assert($parser->registerMatcher($this->matcher), is_true);
	}

	public function testParserKnowsAboutMatcher()
	{
		$parser = MatcherParser::getInstance();
		$this->assert($parser->matcherIsRegistered(get_class($this->matcher)), is_true);
	}

	public function testSupportedSyntaxesAreUnique()
	{
		$service = new MatcherSyntaxAndDescription();
		$syntaxes = array_keys($service->process($this->matcher->supportedSyntaxes()));
		$this->assert(count($syntaxes), equals, count(array_unique($syntaxes)));
	}

	protected function createStdClassThatCanBeCastToString($value)
	{
		return $this->mock()->stub(array('__toString' => $value))->done();
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
			$this->assert($this->matcher->match($syntax, $args), is_false);
		}
		catch(DidNotMatchException $e) {
			$this->assert(true);
		}
	}

	/**
	 * @param string $syntax
	 */
	protected function assertMatcherSuccess($syntax, array $args = array())
	{
		$this->assertTrue($this->matcher->match($syntax, $args));
	}

	protected function assertFailure()
	{
		try {
			call_user_func_array(array($this, 'assert'), func_get_args());
		}
		catch(\PHPUnit_Framework_AssertionFailedError $e) {
			$this->assertTrue(true);
			return;
		}
		$this->fail("Assertion did not fail.");
	}
}
