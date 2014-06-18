<?php

namespace Concise;

use Concise\Syntax\MatcherParser;

class TestCase extends \PHPUnit_Framework_TestCase
{
	protected function getMatcherParserInstance()
	{
		return MatcherParser::getInstance();
	}

	public function __get($name)
	{
		if(!isset($this->$name)) {
			throw new \Exception("No such attribute '{$name}'.");
		}
		return $this->$name;
	}

	public function __set($name, $value)
	{
		$parser = MatcherParser::getInstance();
		if(in_array($name, $parser->getKeywords())) {
			throw new \Exception("You cannot assign an attribute with the keyword '$name'.");
		}
		$this->$name = $value;
	}

	public function getData()
	{
		return get_object_vars($this);
	}

	/**
	 * @param string $class
	 */
	protected function getStub($class, array $methods, array $constructorArgs = array())
	{
		// @test force class to exist
		// @test force class to be fully qualified
		$stub = $this->getMock($class, array_keys($methods), $constructorArgs);
		foreach($methods as $method => $returnValue) {
			$stub->expects($this->any())
			     ->method($method)
			     ->will($this->returnValue($returnValue));
		}
		return $stub;
	}

	protected function getRealTestName()
	{
		$name = substr($this->getName(), 20);
		$pos = strpos($name, ':');
		return substr($name, 0, $pos);
	}

	/**
	 * These attributes are provided by the base PHPUnit classes.
	 * @return array
	 */
	public static function getPHPUnitProperties()
	{
		return array(
			'backupGlobals' => null,
			'backupGlobalsBlacklist' => array(),
			'backupStaticAttributes' => null,
			'backupStaticAttributesBlacklist' => array(),
			'runTestInSeparateProcess' => null,
			'preserveGlobalState' => true,
		);
	}

	public function assert($assertionString)
	{
		$assertion = $this->getMatcherParserInstance()->compile($assertionString, $this->getData());
		$assertion->setTestCase($this);
		$assertion->run();
	}

	public function tearDown()
	{
		if(substr($this->getName(), 4, 1) === '_') {
			$assertion = str_replace("_", " ", substr($this->getName(), 5));
			$this->assert($assertion);
		}
		parent::tearDown();
	}
}
