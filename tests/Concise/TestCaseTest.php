<?php

namespace Concise;

class TestCaseTest extends TestCase
{
    public function testExtendsTestCase()
    {
        $this->assert(new TestCase(), is_an_instance_of, '\PHPUnit_Framework_TestCase');
    }

    protected function assertAssertions(array $expected, array $actual)
    {
        $this->assert(count($actual), equals, count($expected));
        $right = array();
        foreach ($actual as $a) {
            $right[] = $a->getAssertion();
        }
        $this->assert($right, equals, $expected);
    }

    public function testCanSetAttribute()
    {
        $this->myAttribute = 123;
        $this->assert(123, exactly_equals, $this->myAttribute);
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
        $this->assert($data['x'], exactly_equals, 123);
    }

    public function testCanUnsetProperty()
    {
        $this->myUniqueProperty = 123;
        unset($this->myUniqueProperty);
        $this->assert(isset($this->myUniqueProperty), is_false);
    }

    public function testUnsettingAnAttributeThatDoesntExistDoesNothing()
    {
        unset($this->foobar);
        $this->assert(isset($this->myUniqueProperty), is_false);
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
        $this->assert($this->getData(), has_key, 'mySpecialAttribute');
    }

    public function testIssetWorksWithAttributes()
    {
        $this->x = 123;
        $this->assert(isset($this->x));
    }

    public function testDataIsResetBetweenTests()
    {
        $this->assert(isset($this->x), is_false);
    }

    protected function getAssertionsForFixtureTests()
    {
        $testCase = $this->niceMock('\Concise\TestCase')
                         ->stub(array(
                             'getRawAssertionsForMethod' => array(
                                'x equals b',
                                'false',
                                'true',
                            )
                         ))
                         ->get();

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

    public function testCreatingAMockAddsItToTheMocks()
    {
        $this->mock()->get();
        $this->assert(count($this->_mocks), equals, 1);
    }

    public function testCreatingANiceMockAddsItToTheMocks()
    {
        $this->niceMock()->get();
        $this->assert(count($this->_mocks), equals, 1);
    }

    public function testCreatingMultipleMocksAddsAllToMocks()
    {
        $this->mock()->get();
        $this->niceMock()->get();
        $this->assert(count($this->_mocks), equals, 2);
    }

    public function testCallingDoneTwiceWillGenerateTwoMocksAndBothWillBeRegistered()
    {
        $mockTemplate = $this->mock();
        $mockTemplate->get();
        $mockTemplate->get();
        $this->assert(count($this->_mocks), equals, 2);
    }
}
