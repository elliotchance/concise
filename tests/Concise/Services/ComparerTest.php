<?php

namespace Concise\Services;

class ComparerTest extends \Concise\TestCase
{
	/** @var Comparer */
	protected $comparer;

	public function setUp()
	{
		parent::setUp();
		$this->comparer = new Comparer();
	}
	
	public function testAllNonspecificComparisonsUseConvertToString()
	{
		$convertToStringMock = $this->mock('\Concise\Services\ToStringConverter')
		                            ->expect('convertToString')->twice()
		                            ->done();
		$this->comparer->setConvertToString($convertToStringMock);

		$this->comparer->compare("abc", "abc");
	}

	public function testBooleansAreSupported()
	{
		$this->assert($this->comparer->compare(true, true));
	}

	public function testNullsAreSupported()
	{
		$this->assert($this->comparer->compare(null, null));
	}

	public function testFailureReturnsFalse()
	{
		$this->assert($this->comparer->compare(true, false), is_false);
	}

	/**
	 * @param string $value
	 * @return ToStringConverter
	 */
	protected function getConvertToStringMockThatExpects($value)
	{
		$convertToStringMock = $this->mock('\Concise\Services\ToStringConverter')
		                            ->expect('convertToString')->with($value)
		                            ->done();
		return $convertToStringMock;
	}

	public function testOnlyFirstArgumentNeedsToFallBackToConvertToString()
	{
		$this->comparer->setConvertToString($this->getConvertToStringMockThatExpects('abc'));
		$this->comparer->compare("abc", true);
	}

	public function testOnlySecondArgumentNeedsToFallBackToConvertToString()
	{
		$this->comparer->setConvertToString($this->getConvertToStringMockThatExpects('def'));
		$this->comparer->compare(null, "def");
	}

	public function testComparisonsAreExact()
	{
		$this->assert($this->comparer->compare(false, ''), is_false);
	}

	public function testResourcesAreSupported()
	{
		$this->assert($this->comparer->compare(fopen('.', 'r'), null), is_false);
	}

	public function testMatchingAnObjectWithItselfAlwaysMatches()
	{
		$obj = new \stdClass();
		$this->assert($this->comparer->compare($obj, $obj));
	}
}
