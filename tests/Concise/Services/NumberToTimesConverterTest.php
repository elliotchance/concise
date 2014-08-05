<?php

namespace Concise\Services;

use \Concise\TestCase;

class NumberToTimesConverterTest extends TestCase
{
	protected $converter;

	public function setUp()
	{
		parent::setUp();
		$this->converter = new NumberToTimesConverter();
	}

	public function testOneIsOnce()
	{
		$this->assert($this->converter->convert(1), equals, 'once');
	}

	public function testZeroIsNever()
	{
		$this->assert($this->converter->convert(0), equals, 'never');
	}

	public function testTwoIsTwice()
	{
		$this->assert($this->converter->convert(2), equals, 'twice');
	}

	public function testStringsThatLookLikeNumbersAreAllowed()
	{
		$this->assert($this->converter->convert('2'), equals, 'twice');
	}

	public function testAnyOtherNumberIsPluralized()
	{
		$this->assert($this->converter->convert(123), equals, '123 times');
	}

	public function testMethodForOneIsOnce()
	{
		$this->assert($this->converter->convertToMethod(1), equals, 'once()');
	}

	public function testMethodForTwoIsTwice()
	{
		$this->assert($this->converter->convertToMethod(2), equals, 'twice()');
	}
}
