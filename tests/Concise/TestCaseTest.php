<?php

namespace Concise;

class TestCaseStub extends TestCase
{
	function a() {}
	function b() {}
}

class TestCaseTest extends TestCase
{
	public function testExtendsTestCase()
	{
		$this->assertInstanceOf('\Concise\TestCase', new TestCase());
	}

	public function testCountAllTests()
	{
		$testCase = new TestCaseStub();
		$this->assertEquals(2, $testCase->countConciseTests());
	}

	public function testIsConciseTestIsTrueIfMethodStartsWithAnUnderscore()
	{
		$testCase = new TestCase();
		$this->assertTrue($testCase->isConciseTest('_a'));
	}

	public function testIsConciseTestIsFalseIfMethodDoesNotStartWithAnUnderscore()
	{
		$testCase = new TestCase();
		$this->assertFalse($testCase->isConciseTest('a'));
	}
}
