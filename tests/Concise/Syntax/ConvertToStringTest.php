<?php

namespace Concise\Syntax;

class ConvertToStringTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Cannot convert boolean to string.
	 */
	public function testWillThrowExceptionIfABooleanTrueValueIsUsed()
	{
		$converter = new ConvertToString();
		$converter->convertToString(true);
	}
}
