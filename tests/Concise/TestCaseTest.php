<?php

namespace Concise;

class TestCaseStub extends TestCase
{
	function test_a() {}
	function test_b() { return 'a'; }
	function test_c() { return array('a', 'b'); }
	function b() {}
}

class TestCaseStub2 extends TestCase
{
	function test_a() { return 123; }
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
		$this->assertEquals(4, $testCase->countConciseTests());
	}

	public function testIsConciseTestIsTrueIfMethodStartsWithTestUnderscore()
	{
		$testCase = new TestCaseStub();
		$this->assertTrue($testCase->isConciseTest('test_a'));
	}

	public function testIsConciseTestIsFalseIfMethodDoesNotStartWithTestUnderscore()
	{
		$testCase = new TestCaseStub();
		$this->assertFalse($testCase->isConciseTest('a'));
	}

	/**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage $method can not be blank.
	 */
	public function testIsConciseTestThrowsInvalidArgumentExceptionIfTheMethodIsBlank()
	{
		$testCase = new TestCaseStub();
		$this->assertFalse($testCase->isConciseTest(''));
	}

	/**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage $method must be a string.
	 */
	public function testIsConciseTestThrowsInvalidArgumentExceptionIfTheMethodIsNotAString()
	{
		$testCase = new TestCaseStub();
		$this->assertFalse($testCase->isConciseTest(123));
	}

	public function testCountAssertionsForTestReturnsOneIfThereIsNoReturnValue()
	{
		$testCase = new TestCaseStub();
		$this->assertEquals(1, $testCase->countAssertionsForMethod('test_a'));
	}

	public function testCountAssertionsForTestReturnsZeroIfItIsNotAValidMethodName()
	{
		$testCase = new TestCaseStub();
		$this->assertEquals(0, $testCase->countAssertionsForMethod('a'));
	}

	public function testCountAssertionsForTestReturnsOneIfTheReturnValueIsAString()
	{
		$testCase = new TestCaseStub();
		$this->assertEquals(1, $testCase->countAssertionsForMethod('test_b'));
	}

	public function testCountAssertionsForTestReturnsArraySizeIfTheReturnValueIsAnArray()
	{
		$testCase = new TestCaseStub();
		$this->assertEquals(2, $testCase->countAssertionsForMethod('test_c'));
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Test method 'test_a' must return void, string or an array of strings.
	 */
	public function testCountAssertionsForTestThrowsExceptionIfReturnValueIsNotValid()
	{
		$testCase = new TestCaseStub2();
		$this->assertFalse($testCase->countAssertionsForMethod('test_a'));
	}
}
