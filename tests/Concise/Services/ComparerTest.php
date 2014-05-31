<?php

namespace Concise\Services;

class ComparerTest extends \Concise\TestCase
{
	public function prepare()
	{
		parent::prepare();
		$this->comparer = new Comparer();
	}

	// @test getMock wont behave correctly unless inside a running test
	public function testAllNonspecificComparisonsUseConvertToString()
	{
		$convertToStringMock = $this->getMock('\Concise\Services\ConvertToString');
		$convertToStringMock->expects($this->exactly(2))
		                    ->method('convertToString');
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

	protected function getConvertToStringMockThatExpects($value)
	{
		$convertToStringMock = $this->getMock('\Concise\Services\ConvertToString');
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
