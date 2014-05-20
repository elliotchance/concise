<?php

namespace Concise;

use \Concise\Syntax\Lexer;
use \Concise\Syntax\Attribute;
use \Concise\Syntax\Code;

class Assertion
{
	/** @var \Concise\Matcher\AbstractMatcher */
	protected $matcher;

	protected $assertionString;

	protected $data = array();

	/** @var \PHPUnit_Framework_TestCase */
	protected $testCase = null;

	protected $description = '';

	protected $shouldRunPrepare;

	protected $shouldRunFinalize;

	public function __construct($assertionString, Matcher\AbstractMatcher $matcher, array $data = array(), $shouldRunPrepare = false, $shouldRunFinalize = false)
	{
		$this->assertionString = $assertionString;
		$this->matcher = $matcher;
		$this->data = $data;
		$this->shouldRunPrepare = $shouldRunPrepare;
		$this->shouldRunFinalize = $shouldRunFinalize;
	}

	public function setTestCase(\PHPUnit_Framework_TestCase $testCase)
	{
		$this->testCase = $testCase;
	}
	
	public function getAssertion()
	{
		return $this->assertionString;
	}
	
	public function getData()
	{
		return $this->data;
	}

	public function getMatcher()
	{
		return $this->matcher;
	}

	/**
	 * @return bool
	 */
	protected function executeAssertion()
	{
		$lexer = new Lexer();
		$result = $lexer->parse($this->getAssertion());

		$data = $this->getData();
		for($i = 0; $i < count($result['arguments']); ++$i) {
			$arg = $result['arguments'][$i];
			if($arg instanceof Attribute) {
				$result['arguments'][$i] = $data[$arg->getName()];
			}
			else if($arg instanceof Code) {
				$result['arguments'][$i] = eval('return ' . $arg->getCode() . ';');
			}
		}

		if(true === $this->getMatcher()->match($result['syntax'], $result['arguments'])) {
			return true;
		}
		return $this->getMatcher()->renderFailureMessage($result['syntax'], $result['arguments']);
	}

	public function fail($reason)
	{
		if(!is_object($this->testCase)) {
			throw new \Exception();
		}
		$this->testCase->fail($reason);
	}

	public function success()
	{
		$this->testCase->assertTrue(true);
	}

	public function run()
	{
		if($this->shouldRunPrepare()) {
			$this->testCase->prepare();
		}
		if(null !== $this->testCase) {
			$this->testCase->setCurrentAssertion($this);
		}
		$result = $this->executeAssertion();
		if(true === $result) {
			$this->success();
		}
		else {
			$this->fail($result);
		}
		if($this->shouldRunFinalize()) {
			$this->testCase->finalize();
		}
	}

	public function __toString()
	{
		$r = "";
		foreach($this->getData() as $k => $v) {
			$r .= "\n  $k = " . var_export($v, true);
		}
		return "$r\n";
	}

	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function getDescription()
	{
		if('' === $this->description) {
			return $this->getAssertion();
		}
		return $this->description . " (" . $this->getAssertion() . ")";
	}

	public function shouldRunPrepare()
	{
		return $this->shouldRunPrepare;
	}

	public function shouldRunFinalize()
	{
		return $this->shouldRunFinalize;
	}

	public function setShouldRunPrepare($shouldRunPrepare)
	{
		$this->shouldRunPrepare = $shouldRunPrepare;
	}

	public function setShouldRunFinalize($shouldRunFinalize)
	{
		$this->shouldRunFinalize = $shouldRunFinalize;
	}
}
