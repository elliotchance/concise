<?php

namespace Concise;

class TestCaseStub1 extends TestCase
{
	function _test_a_equals_b() {}
	function _test_b() { return 'b equals a'; }
	function _test_c() { return array('c equals d', 'd equals c'); }
	function b() {}
	function getMatcherParserInstance() {
		$matcherParser = new MatcherParser();
		$matcherParser->registerMatcher(new Matcher\EqualTo());
		return $matcherParser;
	}
}

class TestCaseStub2 extends TestCase
{
	function _test_a() { return 123; }
	function _test_b() { return array(123, 'abc'); }
}

class TestCaseTest extends TestCase
{
	public function testExtendsTestCase()
	{
		$this->assertInstanceOf('\Concise\TestCase', new TestCase());
	}

	public function testCountAllTests()
	{
		$testCase = new TestCaseStub1();
		$this->assertEquals(4, $testCase->countConciseTests());
	}

	public function testIsConciseTestIsTrueIfMethodStartsWithTestUnderscore()
	{
		$testCase = new TestCaseStub1();
		$this->assertTrue($testCase->isConciseTest('_test_a_equals_b'));
	}

	public function testIsConciseTestIsFalseIfMethodDoesNotStartWithTestUnderscore()
	{
		$testCase = new TestCaseStub1();
		$this->assertFalse($testCase->isConciseTest('a'));
	}

	/**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage $method can not be blank.
	 */
	public function testIsConciseTestThrowsInvalidArgumentExceptionIfTheMethodIsBlank()
	{
		$testCase = new TestCaseStub1();
		$this->assertFalse($testCase->isConciseTest(''));
	}

	/**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage $method must be a string.
	 */
	public function testIsConciseTestThrowsInvalidArgumentExceptionIfTheMethodIsNotAString()
	{
		$testCase = new TestCaseStub1();
		$this->assertFalse($testCase->isConciseTest(123));
	}

	public function testCountAssertionsForTestReturnsOneIfThereIsNoReturnValue()
	{
		$testCase = new TestCaseStub1();
		$this->assertEquals(1, $testCase->countAssertionsForMethod('_test_a_equals_b'));
	}

	public function testCountAssertionsForTestReturnsZeroIfItIsNotAValidMethodName()
	{
		$testCase = new TestCaseStub1();
		$this->assertEquals(0, $testCase->countAssertionsForMethod('a'));
	}

	public function testCountAssertionsForTestReturnsOneIfTheReturnValueIsAString()
	{
		$testCase = new TestCaseStub1();
		$this->assertEquals(1, $testCase->countAssertionsForMethod('_test_b'));
	}

	public function testCountAssertionsForTestReturnsArraySizeIfTheReturnValueIsAnArray()
	{
		$testCase = new TestCaseStub1();
		$this->assertEquals(2, $testCase->countAssertionsForMethod('_test_c'));
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Test method '_test_a' must return void, string or an array of strings.
	 */
	public function testCountAssertionsForTestThrowsExceptionIfReturnValueIsNotValid()
	{
		$testCase = new TestCaseStub2();
		$this->assertFalse($testCase->countAssertionsForMethod('_test_a'));
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Test method '_test_b' returns an array that must contain only strings.
	 */
	public function testCountAssertionsForTestThrowsExceptionIfReturnValueIsAnArrayOfNotAllStrings()
	{
		$testCase = new TestCaseStub2();
		$this->assertFalse($testCase->countAssertionsForMethod('_test_b'));
	}

	public function testGetAssertionsForMethodThatDoesNotReturnAValueUsesTheMethodName()
	{
		$testCase = new TestCaseStub1();
		$this->assertEquals(array('a equals b'), $testCase->getAssertionsForMethod('_test_a_equals_b'));
	}

	public function testGetAssertionsForMethodThatReturnsAStringWillReturnThat()
	{
		$testCase = new TestCaseStub1();
		$this->assertEquals(array('b equals a'), $testCase->getAssertionsForMethod('_test_b'));
	}

	public function testGetAssertionsForMethodThatReturnsAnArrayWillReturnThat()
	{
		$testCase = new TestCaseStub1();
		$expected = array('c equals d', 'd equals c');
		$this->assertEquals($expected, $testCase->getAssertionsForMethod('_test_c'));
	}

	public function testGetAllAssertions()
	{
		$testCase = new TestCaseStub1();
		$expected = array(
			'_test_a_equals_b' => array('a equals b'),
			'_test_b' => array('b equals a'),
			'_test_c' => array('c equals d', 'd equals c')
		);
		$this->assertEquals($expected, $testCase->getAllAssertions());
	}

	public function testConvertMethodNameToAssertionReplacesUnderscoresWithSpaces()
	{
		$testCase = new TestCaseStub1();
		$this->assertEquals('a equals b', $testCase->convertMethodNameToAssertion('_test_a_equals_b'));
	}

	public function testDataProviderReturnsAssertions()
	{
		$testCase = new TestCaseStub1();
		$expected = array(
			'_test_a_equals_b: a equals b',
			'_test_b: b equals a',
			'_test_c: c equals d',
			'_test_c: d equals c'
		);
		$this->assertEquals($expected, array_keys($testCase->dataProvider()));
	}

	public function testCanSetAttribute()
	{
		$this->myAttribute = 123;
		$this->assertSame(123, $this->myAttribute);
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage No such attribute 'noSuchAttribute'.
	 */
	public function testGetAttributeThatDoesNotExistThrowsException()
	{
		$this->noSuchAttribute;
	}

	public function testDataProviderWillAlwaysContainAtLeastOneItem()
	{
		$stub = $this->getStub('\Concise\TestCase', array(
			'getAllAssertions' => array()
		));
		$this->assertCount(1, $stub->dataProvider());
	}

	public function testCanExtractDataFromTest()
	{
		$this->a = 123;
		$this->b = '456';
		$expected = array('a', 'b');
		$this->assertEquals($expected, array_keys($this->getData()));
	}

	public function testDataIsAnEmptyArrayIsNotInitialised()
	{
		$this->assertEquals(array(), array_keys($this->getData()));
	}
}
