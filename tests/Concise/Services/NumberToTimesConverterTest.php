<?php

namespace Concise\Services;

use \Concise\TestCase;

class NumberToTimesConverterTest extends TestCase
{
	public function testOneIsOnce()
	{
		$converter = new NumberToTimesConverter();
		$this->assert($converter->convert(1), equals, 'once');
	}

	public function testZeroIsNever()
	{
		$converter = new NumberToTimesConverter();
		$this->assert($converter->convert(0), equals, 'never');
	}

	public function testTwoIsTwice()
	{
		$converter = new NumberToTimesConverter();
		$this->assert($converter->convert(2), equals, 'twice');
	}

	public function testStringsThatLookLikeNumbersAreAllowed()
	{
		$converter = new NumberToTimesConverter();
		$this->assert($converter->convert('2'), equals, 'twice');
	}
}
