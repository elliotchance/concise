<?php

namespace Concise\Services;

class ComparerTest extends \Concise\TestCase
{
	public function testTrueEqualsTrue()
	{
		$comparer = new Comparer();
		$this->assertTrue($comparer->compare(true, true));
	}

	public function testTrueDoesNotEqualFalse()
	{
		$comparer = new Comparer();
		$this->assertFalse($comparer->compare(true, false));
	}
}
