<?php

namespace Concise\Core;

use ReflectionClass;

class TestCaseTest extends TestCase
{
    protected $mySpecialAttribute = 123;

    public function testExtendsTestCase()
    {
        $this->assert('\Concise\Core\TestCase')
            ->isAnInstanceOf('\PHPUnit_Framework_TestCase');
    }

    public function testCanSetAttribute()
    {
        $this->myAttribute = 123;
        $this->assert(123)->exactlyEquals($this->myAttribute);
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

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage No such syntax "? foo bar"
     */
    public function testNoSuchAssertion()
    {
        $this->assert('a')->fooBar;
        $this->assert(123)->equals("123");
    }

    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage No such method Concise\Core\TestCaseTest::something()
     * @group #317
     */
    public function testWillCallBadMethodCallExceptionForUnknownMethod()
    {
        $this->something();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage No such syntax "something ?"
     * @group #317
     */
    public function testWillNotCallBadMethodCallExceptionIsPrefixedWithAssert()
    {
        $this->assertSomething(123);
        $this->assert(123)->equals("123");
    }

    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage No such method Concise\Core\TestCaseTest::a()
     * @group #317
     */
    public function testMethodCallsLessThan6Characters()
    {
        $this->a();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage No such syntax "something ?"
     * @group #317
     */
    public function testAssertPrefixIsNotCaseSensitive()
    {
        $this->AssertSomething(123);
        $this->assert(123)->equals("123");
    }

    public function testIsAbstract()
    {
        $class = new ReflectionClass('\Concise\Core\TestCase');
        $this->assert($class->isAbstract())->isTrue;
    }
}
