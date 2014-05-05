<?php

namespace Concise;

class TestCaseTest extends \PHPUnit_Framework_TestCase
{
	public function testExtendsTestCase()
	{
		$this->assertInstanceOf('\Concise\TestCase', new TestCase());
	}
}
