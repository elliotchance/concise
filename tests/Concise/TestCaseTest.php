<?php

namespace Concise;

use \Concise\Syntax\MatcherParser;

class TestCaseStub1 extends TestCase
{
	function _test_x_equals_b()
	{
	}

	function _test_b()
	{
		return 'b equals x';
	}

	function _test_c()
	{
		return array('c equals d', 'd equals c');
	}

	function b()
	{
	}

	function getMatcherParserInstance()
	{
		$matcherParser = new MatcherParser();
		$matcherParser->registerMatcher(new Matcher\Equals());
		return $matcherParser;
	}
}

class TestCaseStub2 extends TestCase
{
	function _test_x()
	{
		return 123;
	}

	function _test_b()
	{
		return array(123, 'abc');
	}
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
		$this->assertTrue($testCase->isConciseTest('_test_x_equals_b'));
	}

	public function testIsConciseTestIsFalseIfMethodDoesNotStartWithTestUnderscore()
	{
		$testCase = new TestCaseStub1();
		$this->assertFalse($testCase->isConciseTest('x'));
	}

	/**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage $method can not be blank.
	 */
	public function testIsConciseTestThrowsInvalidArgumentExceptionIfTheMethodIsBlank()
	{
		$testCase = new TestCaseStub1();
		$testCase->isConciseTest('');
	}

	/**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage $method must be a string.
	 */
	public function testIsConciseTestThrowsInvalidArgumentExceptionIfTheMethodIsNotAString()
	{
		$testCase = new TestCaseStub1();
		$testCase->isConciseTest(123);
	}

	public function testCountAssertionsForTestReturnsOneIfThereIsNoReturnValue()
	{
		$testCase = new TestCaseStub1();
		$this->assertEquals(1, $testCase->countAssertionsForMethod('_test_x_equals_b'));
	}

	public function testCountAssertionsForTestReturnsZeroIfItIsNotAValidMethodName()
	{
		$testCase = new TestCaseStub1();
		$this->assertEquals(0, $testCase->countAssertionsForMethod('x'));
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
	 * @expectedExceptionMessage Test method '_test_x' must return void, string or an array of strings.
	 */
	public function testCountAssertionsForTestThrowsExceptionIfReturnValueIsNotValid()
	{
		$testCase = new TestCaseStub2();
		$testCase->countAssertionsForMethod('_test_x');
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Test method '_test_b' returns an array that must contain only strings.
	 */
	public function testCountAssertionsForTestThrowsExceptionIfReturnValueIsAnArrayOfNotAllStrings()
	{
		$testCase = new TestCaseStub2();
		$testCase->countAssertionsForMethod('_test_b');
	}

	protected function assertAssertions(array $expected, array $actual)
	{
		$this->assertEquals(count($expected), count($actual));
		$right = array();
		foreach($actual as $a) {
			$right[] = $a->getAssertion();
		}
		$this->assertEquals($expected, $right);
	}

	public function testGetAssertionsForMethodThatDoesNotReturnAValueUsesTheMethodName()
	{
		$testCase = new TestCaseStub1();
		$this->assertAssertions(array('x equals b'), $testCase->getAssertionsForMethod('_test_x_equals_b'));
	}

	public function testGetAssertionsForMethodThatReturnsAStringWillReturnThat()
	{
		$testCase = new TestCaseStub1();
		$this->assertAssertions(array('b equals x'), $testCase->getAssertionsForMethod('_test_b'));
	}

	public function testGetAssertionsForMethodThatReturnsAnArrayWillReturnThat()
	{
		$testCase = new TestCaseStub1();
		$expected = array('c equals d', 'd equals c');
		$this->assertAssertions($expected, $testCase->getAssertionsForMethod('_test_c'));
	}

	public function testGetAllAssertions()
	{
		$testCase = new TestCaseStub1();
		$expected = array(
			'_test_x_equals_b' => array(
				new Assertion('x equals b', new Matcher\Equals(), array(), true, true),
			),
			'_test_b' => array(
				new Assertion('b equals x', new Matcher\Equals(), array(), true, true),
			),
			'_test_c' => array(
				new Assertion('c equals d', new Matcher\Equals(), array(), true, false),
				new Assertion('d equals c', new Matcher\Equals(), array(), false, true),
			)
		);
		$this->assertEquals($expected, $testCase->getAllAssertions());
	}

	public function testConvertMethodNameToAssertionReplacesUnderscoresWithSpaces()
	{
		$testCase = new TestCaseStub1();
		$this->assertEquals('x equals b', $testCase->convertMethodNameToAssertion('_test_x_equals_b'));
	}

	public function testDataProviderReturnsAssertions()
	{
		$testCase = new TestCaseStub1();
		$expected = array(
			'_test_x_equals_b: x equals b',
			'_test_b: b equals x',
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
		$this->x = 123;
		$this->b = '456';
		$data = $this->getData();
		$this->assertSame($data['x'], 123);
	}

	public function testCanUnsetProperty()
	{
		$this->myUniqueProperty = 123;
		unset($this->myUniqueProperty);
		$this->assertFalse(isset($this->myUniqueProperty));
	}

	public function testUnsettingAnAttributeThatDoesntExistDoesNothing()
	{
		unset($this->foobar);
		$this->assertFalse(isset($this->myUniqueProperty));
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage You cannot assign an attribute with the keyword 'not'.
	 */
	public function testAssigningAnAttributeThatIsAKeywordThrowsAnException()
	{
		$this->not = 123;
	}

	protected $mySpecialAttribute = 123;

	public function testDataIncludesExplicitInstanceVariables()
	{
		$this->assertTrue(array_key_exists('mySpecialAttribute', $this->getData()));
	}

	public function testIssetWorksWithAttributes()
	{
		$this->x = 123;
		$this->assertTrue(isset($this->x));
	}

	public function testDataIsResetBetweenTests()
	{
		$this->assertFalse(isset($this->x));
	}

	public function expectedFixtureStatuses()
	{
		return array(
			array(0, true, false),
			array(1, false, false),
			array(2, false, true),
		);
	}

	protected function getAssertionsForFixtureTests()
	{
		$testCase = $this->getStub('\Concise\TestCase', array(
			'getRawAssertionsForMethod' => array(
				'x equals b',
				'false',
				'true',
			)
		));
		return $testCase->getAssertionsForMethod('abc');
	}

	/**
	 * @dataProvider expectedFixtureStatuses
	 */
	public function testGetAssertionsForMethodWillSetPrepareStatus($assertionIndex, $shouldRunPrepare, $shouldRunFinalize)
	{
		$assertions = $this->getAssertionsForFixtureTests();
		$this->assertSame($shouldRunPrepare, $assertions[$assertionIndex]->shouldRunPrepare());
	}

	/**
	 * @dataProvider expectedFixtureStatuses
	 */
	public function testGetAssertionsForMethodWillSetFinalizeStatus($assertionIndex, $shouldRunPrepare, $shouldRunFinalize)
	{
		$assertions = $this->getAssertionsForFixtureTests();
		$this->assertSame($shouldRunFinalize, $assertions[$assertionIndex]->shouldRunFinalize());
	}

	public function testPrepareIsCalledBySetup()
	{
		$testCase = $this->getMock('\Concise\TestCase', array('prepare'));
		$testCase->expects($this->once())
		         ->method('prepare')
		         ->will($this->returnValue(null));
		$testCase->setUp();
	}

	public function testFinalizeIsCalledByTearDown()
	{
		$testCase = $this->getMock('\Concise\TestCase', array('finalize'));
		$testCase->expects($this->once())
		         ->method('finalize')
		         ->will($this->returnValue(null));
		$testCase->tearDown();
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage There must be at least one assertion returned from the test 'myTest'.
	 */
	public function testWillThrowExceptionIfTestMethodReturnsEmptyArray()
	{
		$testCase = $this->getStub('\Concise\TestCase', array(
			'runMethod' => array()
		));
		$testCase->getRawAssertionsForMethod('myTest');
	}
}
