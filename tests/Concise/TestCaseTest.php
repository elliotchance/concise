<?php

namespace Concise;

// This must go outside of any testing code becuase we know that the constants
// are available before test initialisation.
if (!defined('has_key')) {
    throw new \Exception("Constants not initialised.");
}

class TestCaseTest extends TestCase
{
    public function testExtendsTestCase()
    {
        $this->aassert(new TestCase())
            ->isAnInstanceOf('\PHPUnit_Framework_TestCase');
    }

    protected function assertAssertions(array $expected, array $actual)
    {
        $this->aassert(count($actual))->equals(count($expected));
        $right = array();
        foreach ($actual as $a) {
            /** @var Assertion $a */
            $right[] = $a->getAssertion();
        }
        $this->aassert($right)->equals($expected);
    }

    public function testCanSetAttribute()
    {
        $this->myAttribute = 123;
        $this->aassert(123)->exactlyEquals($this->myAttribute);
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
        $this->aassert($data['x'])->exactlyEquals(123);
    }

    public function testCanUnsetProperty()
    {
        $this->myUniqueProperty = 123;
        unset($this->myUniqueProperty);
        $this->aassert(isset($this->myUniqueProperty))->isFalse;
    }

    public function testUnsettingAnAttributeThatDoesntExistDoesNothing()
    {
        unset($this->foobar);
        $this->aassert(isset($this->myUniqueProperty))->isFalse;
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage You cannot assign an attribute with the
     *     keyword 'not'.
     */
    public function testAssigningAnAttributeThatIsAKeywordThrowsAnException()
    {
        $this->not = 123;
    }

    protected $mySpecialAttribute = 123;

    public function testDataIncludesExplicitInstanceVariables()
    {
        $this->aassert($this->getData())->hasKey('mySpecialAttribute');
    }

    public function testIssetWorksWithAttributes()
    {
        $this->x = 123;
        $this->aassert(isset($this->x))->isTrue;
    }

    public function testDataIsResetBetweenTests()
    {
        $this->aassert(isset($this->x))->isFalse;
    }

    protected function getAssertionsForFixtureTests()
    {
        $testCase = $this->niceMock('\Concise\TestCase')->stub(
            array(
                'getRawAssertionsForMethod' => array(
                    'x equals b',
                    'false',
                    'true',
                )
            )
        )->get();

        return $testCase->getAssertionsForMethod('abc');
    }

    public function testAssertionBuilder()
    {
        $this->aassert(123)->equals("123");
    }

    public function testConstantsForKeywordsAreInitialised()
    {
        $this->aassert(equals)->exactlyEquals('equals');
    }

    public function testConstantsForKeywordStringsAreInitialised()
    {
        $this->aassert(exactly_equals)->exactlyEquals('exactly equals');
    }
}
