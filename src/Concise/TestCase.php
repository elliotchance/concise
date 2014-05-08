<?php

namespace Concise;

class TestCase extends \PHPUnit_Framework_TestCase
{
	protected $data = array();

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

	public function countAssertionsForMethod($method)
	{
		if(!$this->isConciseTest($method)) {
			return 0;
		}
		$return = $this->$method();
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

	public function getAssertionsForMethod($method)
	{
		// @test each test data is cleared out between tests
		$return = $this->$method();
		if($return === null) {
			$assertions = array($this->convertMethodNameToAssertion($method));
		}
		else if(is_array($return)) {
			$assertions = $return;
		}
		else {
			$assertions = array($return);
		}

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
			return array(
				// TODO this should be replaced with $parser->compile('true')
				array(new Assertion('true', new Matcher\True(), array()))
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
		$this->data[$name] = $value;
	}

	public function __unset($name)
	{
		unset($this->data[$name]);
	}

	public function getData()
	{
		$data = array();
		foreach($this->data as $k => $v) {
			$data[$k] = $this->$k;
		}
		return $data;
	}

	protected function getStub($class, array $methods, array $constructorArgs = array())
	{
		$stub = $this->getMock($class, array_keys($methods), $constructorArgs);
		foreach($methods as $method => $returnValue) {
			$stub->expects($this->any())
			     ->method($method)
			     ->will($this->returnValue($returnValue));
		}
		return $stub;
	}
}
