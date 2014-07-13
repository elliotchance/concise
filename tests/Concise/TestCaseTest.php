<?php

namespace Concise;

use \Concise\Syntax\MatcherParser;

class TestCaseTest extends TestCase
{
	public function testExtendsTestCase()
	{
		$this->assert('`new \Concise\TestCase()` is an instance of \PHPUnit_Framework_TestCase');
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

	public function testInlineAssertion()
	{
		$this->abc = 123;
		$this->assert('abc equals 123');
	}

	public function testAssertionBuilder()
	{
		$this->assert(123, 'equals', "123");
	}

	public function testEachTestMethodSetsTheCurrentTestCaseForRawAssertKeyword()
	{
		global $_currentTestCase;
		$this->assertSame($this, $_currentTestCase);
	}

	public function testCanUseAssertThatFunction()
	{
		assert_that("123 equals 123");
	}

	public function testConstantsForKeywordsAreInitialised()
	{
		$this->assertSame(equals, 'equals');
	}

	public function testConstantsForKeywordStringsAreInitialised()
	{
		$this->assertSame(exactly_equals, 'exactly equals');
	}

	public function testAssertionBuilderWillBeUsedForBooleanAssertions()
	{
		$this->assert(true);
	}

	public function testMocksAreResetInTheSetup()
	{
		$this->assert($this->_mocks, exactly_equals, array());
	}
}
