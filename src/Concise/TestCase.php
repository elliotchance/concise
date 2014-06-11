<?php

namespace Concise;

use Concise\Syntax\MatcherParser;

class TestCase extends \PHPUnit_Framework_TestCase
{
	protected static $lastTestName;

	public function countConciseTests()
	{
		$assertions = $this->getAllAssertions();
		$count = 0;
		foreach($assertions as $a) {
			$count += count($a);
		}
		return $count;
	}

	public function isConciseTest($method)
	{
		if(!is_string($method)) {
			throw new \InvalidArgumentException('$method must be a string.');
		}
		if($method == '') {
			throw new \InvalidArgumentException('$method can not be blank.');
		}
		return substr($method, 0, 6) === '_test_';
	}

	public function runMethod($method)
	{
		$this->setUp();
		return $this->$method();
	}

	/**
	 * @param string $method
	 */
	public function countAssertionsForMethod($method)
	{
		if(!$this->isConciseTest($method)) {
			return 0;
		}
		$return = $this->runMethod($method);
		if($return === null || is_string($return)) {
			return 1;
		}
		if(is_array($return)) {
			foreach($return as $r) {
				if(!is_string($r)) {
					throw new \Exception("Test method '{$method}' returns an array that must contain only strings.");
				}
			}
			return count($return);
		}
		throw new \Exception("Test method '{$method}' must return void, string or an array of strings.");
	}

	public function convertMethodNameToAssertion($method)
	{
		$method = substr($method, 6);
		return str_replace('_', ' ', $method);
	}

	protected function getRawAssertionsForMethod($method)
	{
		$return = $this->runMethod($method);
		if($return === null) {
			$assertions = array($this->convertMethodNameToAssertion($method));
		}
		else if(is_array($return)) {
			$assertions = $return;
		}
		else {
			$assertions = array($return);
		}
		if(0 == count($assertions)) {
			throw new \Exception("There must be at least one assertion returned from the test '$method'.");
		}
		return $assertions;
	}

	public function getAssertionsForMethod($method)
	{
		$assertions = $this->getRawAssertionsForMethod($method);
		$r = array();
		foreach($assertions as $a) {
			$r[] = $this->getMatcherParserInstance()->compile($a, $this->getData());
		}
		return $r;
	}

	public function getAllAssertions()
	{
		$class = new \ReflectionClass(get_class($this));
		$assertions = array();
		foreach($class->getMethods() as $method) {
			$methodName = $method->getName();
			if($this->isConciseTest($methodName)) {
				$assertions[$methodName] = $this->getAssertionsForMethod($methodName);

			}
		}
		return $assertions;
	}

	protected function getMatcherParserInstance()
	{
		return MatcherParser::getInstance();
	}

	public function dataProvider()
	{
		$assertions = $this->getAllAssertions();
		$r = array();
		foreach($assertions as $method => $assertion) {
			foreach($assertion as $a) {
				$r["$method: " . $a->getAssertion()] = array($a);
			}
		}

		if(count($r) === 0) {
			$parser = MatcherParser::getInstance();
			return array(
				array($parser->compile('true'))
			);
		}

		return $r;
	}

	/**
	 * @dataProvider dataProvider
	 */
	public function test($assertion)
	{
		$assertion->setTestCase($this);
		$assertion->run();
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

	protected function shouldRunFixtures()
	{
		return substr($this->getName(), 0, 5) !== 'test ';
	}

	/**
	 * @param string $assertionSyntax
	 */
	protected function assertionsForDataSet($assertionSyntax, $dataSet)
	{
		// @test dataSet does not show up as an attribute when test fails
		// @test $dataSet with assoc array is not supported
		$this->__dataSet = $dataSet;
		$assertions = array();
		$parts = explode('?', $assertionSyntax);
		for($i = 0; $i < count($dataSet); ++$i) {
			$assertion = $parts[0];
			for($j = 1; $j < count($parts); ++$j) {
				$assertion .= '$self->__dataSet[' . $i . '][' . ($j - 1) . ']' . $parts[$j];
			}
			$assertions[] = $assertion;
		}
		return $assertions;
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
}
