<?php

namespace Concise\Core;

class TestCaseTest extends TestCase
{
    public function testExtendsTestCase()
    {
        $this->assert(new TestCase())
            ->isAnInstanceOf('\PHPUnit_Framework_TestCase');
    }

    protected function assertAssertions(array $expected, array $actual)
    {
        $this->assert(count($actual))->equals(count($expected));
        $right = array();
        foreach ($actual as $a) {
            /** @var Assertion $a */
            $right[] = $a->getAssertion();
        }
        $this->assert($right)->equals($expected);
    }

    public function testCanSetAttribute()
    {
        $this->myAttribute = 123;
        $this->assert(123)->exactlyEquals($this->myAttribute);
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
        $this->assert($data['x'])->exactlyEquals(123);
    }

    public function testCanUnsetProperty()
    {
        $this->myUniqueProperty = 123;
        unset($this->myUniqueProperty);
        $this->assert(isset($this->myUniqueProperty))->isFalse;
    }

    public function testUnsettingAnAttributeThatDoesntExistDoesNothing()
    {
        unset($this->foobar);
        $this->assert(isset($this->myUniqueProperty))->isFalse;
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
        $this->assert($this->getData())->hasKey('mySpecialAttribute');
    }

    public function testIssetWorksWithAttributes()
    {
        $this->x = 123;
        $this->assert(isset($this->x))->isTrue;
    }

    public function testDataIsResetBetweenTests()
    {
        $this->assert(isset($this->x))->isFalse;
    }

    protected function getAssertionsForFixtureTests()
    {
        $testCase = $this->niceMock('\Concise\Core\TestCase')->stub(
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
        $this->assert(123)->equals("123");
    }
}
