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
		$this->assertTrue($this->comparer->compare(true, true));
	}

	public function testNullsAreSupported()
	{
		$this->assertTrue($this->comparer->compare(null, null));
	}

	public function testFailureReturnsFalse()
	{
		$this->assertFalse($this->comparer->compare(true, false));
	}

	/**
	 * @param string $value
	 * @return ToStringConverter
	 */
	protected function getConvertToStringMockThatExpects($value)
	{
		$convertToStringMock = $this->getMock('\Concise\Services\ToStringConverter');
		$convertToStringMock->expects($this->once())
		                    ->method('convertToString')
		                    ->with($value);
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
		$this->assertFalse($this->comparer->compare(false, ''));
	}

	public function testResourcesAreSupported()
	{
		$this->assertFalse($this->comparer->compare(fopen('.', 'r'), null));
	}
}
