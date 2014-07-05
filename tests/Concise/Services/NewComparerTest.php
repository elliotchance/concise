<?php

namespace Concise\Services;

class NewComparerTest extends \Concise\TestCase
{
	protected $comparer;

	public function setUp()
	{
		parent::setUp();
		$this->comparer = new NewComparer();
	}

	public function testComparingTheSameValuesReturnsTrue()
	{
		$this->assert($this->comparer->compare(123, 123));
	}

	public function testComparingDifferentValuesReturnsFalse()
	{
		$this->assert($this->comparer->compare(123, 124), is_false);
	}
}
