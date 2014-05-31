<?php

namespace Concise\Services;

class ComparerTest extends \Concise\TestCase
{
	public function testBooleanValuesCanBeCompared()
	{
		$comparer = new Comparer();
		$this->assertTrue($comparer->compare(true, true));
	}
}
