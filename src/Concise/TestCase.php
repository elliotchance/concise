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
		$return = $this->$method();
		if($return === null) {
			return array($this->convertMethodNameToAssertion($method));
		}
		if(is_array($return)) {
			return $return;
		}
		return array($return);
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

	public function dataProvider()
	{
		$assertions = $this->getAllAssertions();
		$parser = new MatcherParser($this);
		$r = array();
		foreach($assertions as $method => $assertion) {
			foreach($assertion as $a) {
				$r["$method: $a"] = array($parser->compile($a));
			}
		}

		if(count($r) === 0) {
			return array(
				// TODO this should be replace by $parser->compile('true')
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
		$assertion->run($this);
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
		$this->$name = $value;
		$this->data[$name] = $value;
	}

	public function getData()
	{
		return $this->data;
	}

	protected function getStub($class, array $methods)
	{
		$stub = $this->getMock($class, array_keys($methods));
		foreach($methods as $method => $returnValue) {
			$stub->expects($this->any())
			     ->method($method)
			     ->will($this->returnValue($returnValue));
		}
		return $stub;
	}
}
