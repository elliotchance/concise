<?php

namespace Concise\Services;

class ComparerTest extends \Concise\TestCase
{
	// @test getMock wont behave correctly unless inside a running test
	public function testAllNonspecificComparisonsUseConvertToString()
	{
		$convertToStringMock = $this->getMock('\Concise\Services\ConvertToString');
		$convertToStringMock->expects($this->exactly(2))
		                    ->method('convertToString');

		$this->comparer = new Comparer();
		$this->comparer->setConvertToString($convertToStringMock);

		$this->comparer->compare("abc", "abc");
	}

	public function testBooleansAreSupported()
	{
		$this->comparer = new Comparer();
		$this->assertTrue($this->comparer->compare(true, true));
	}
}
