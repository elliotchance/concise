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

	public function testComparingTheSameValuesEqualsTrue()
	{
		$this->assert($this->comparer->compare(123, 123));
	}
}
