<?php

namespace Concise\Validation;

use Concise\Syntax\Token\Attribute;
use Concise\Syntax\Token\Regexp;
use DateTime;

class SubDateTime extends DateTime
{
}

class DataTypeCheckerTest extends \Concise\TestCase
{
    /** @var DataTypeChecker */
    protected $dataTypeChecker;

    public function setUp()
    {
        parent::setUp();
        $this->dataTypeChecker = new DataTypeChecker();
    }

    public function testBlankAcceptsAnything()
    {
        $this->assert(
            $this->dataTypeChecker->check(array(), 123),
            exactly_equals,
            123
        );
    }

    /**
     * @expectedException \Exception
     */
    public function testSendingValueOfDifferentExpectedTypeThrowsException()
    {
        $this->dataTypeChecker->check(array("int"), 1.23);
    }

    public function dataTypes()
    {
        return array(
            'int' => array(array("int"), 123),
            'integer' => array(array("integer"), 123),
            'float' => array(array("float"), 1.23),
            'double' => array(array("double"), 1.23),
            'string' => array(array("string"), 'abc'),
            'array' => array(array("array"), array()),
            'resource' => array(array("resource"), fopen('.', 'r')),
            'object' => array(array("object"), new \stdClass()),
            'callable' => array(
                array("callable"),
                function () {
                }
            ),
            'multiple' => array(array("int", "float"), 1.23),
            'regex' => array(array("regex"), new Regexp('abc')),
            'class' => array(array("class"), 'Concise\Syntax\Token\Regexp'),
            'integer number' => array(array("number"), 123),
            'float number' => array(array("number"), 12.3),
            'string number' => array(array("number"), '12.3'),
            'bool' => array(array("bool"), true),
            'string function' => array(array("string"), 'count'),
            'specific object' => array(array('DateTime'), new DateTime()),
            'specific object backslash' => array(
                array('\DateTime'),
                new DateTime()
            ),
            'subclass object' => array(array('DateTime'), new SubDateTime()),
            'subclass object backslash' => array(
                array('\DateTime'),
                new SubDateTime()
            ),
        );
    }

    /**
     * @dataProvider dataTypes
     */
    public function testDataTypes(array $types, $value)
    {
        $this->assert(
            $value,
            exactly_equals,
            $this->dataTypeChecker->check($types, $value)
        );
    }

    /**
     * @expectedException \Exception
     */
    public function testSendingValueNotListedInExpectedTypesThrowsException()
    {
        $this->dataTypeChecker->check(array("int", "string"), 1.23);
    }

    /**
     * @expectedException \Exception
     */
    public function testExcludeModeWillNotAllowType()
    {
        $this->dataTypeChecker->setExcludeMode();
        $this->dataTypeChecker->check(array("int"), 123);
    }

    public function testAttributesAreEvaluatedFromContext()
    {
        $context = array(
            'foo' => 'bar',
        );
        $this->dataTypeChecker->setContext($context);
        $this->assert(
            $this->dataTypeChecker->check(
                array('string'),
                new Attribute('foo')
            ),
            exactly_equals,
            'bar'
        );
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Attribute 'foo' does not exist.
     */
    public function testWillThrowExceptionIfAttributeDoesNotExist()
    {
        $this->dataTypeChecker->check(array('string'), new Attribute('foo'));
    }

    public function testExcludeWithEmptyArrayAllowsAnything()
    {
        $this->dataTypeChecker->setExcludeMode();
        $this->assert($this->dataTypeChecker->check(array(), 123), equals, 123);
    }

    public function testWillTrimBackslashOffClass()
    {
        $this->assert(
            $this->dataTypeChecker->check(array('class'), '\Concise\TestCase'),
            equals,
            'Concise\TestCase'
        );
    }

    public function testWillNotTrimBackslashOffClassIfNotValidatingAgainstClass(
    )
    {
        $this->assert(
            $this->dataTypeChecker->check(array('string'), '\Concise\TestCase'),
            equals,
            '\Concise\TestCase'
        );
    }

    public function testWillNotTrimBackslashOffClassIfAnyValueCanBeAccepted()
    {
        $this->assert(
            $this->dataTypeChecker->check(array(), '\Concise\TestCase'),
            equals,
            '\Concise\TestCase'
        );
    }

    public function testWillTrimBackslashOffClassWhenInAttribute()
    {
        $context = array(
            'foo' => '\Concise\TestCase',
        );
        $this->dataTypeChecker->setContext($context);
        $this->assert(
            $this->dataTypeChecker->check(array('class'), new Attribute('foo')),
            equals,
            'Concise\TestCase'
        );
    }

    public function testStringsWillBeAcceptedForRegex()
    {
        $this->assertSame(
            '/a/',
            $this->dataTypeChecker->check(array('regex'), '/a/')
        );
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Expected regex, but got integer
     */
    public function testNonStringsWillNotBeAcceptedForRegex()
    {
        $this->dataTypeChecker->check(array('regex'), 123);
    }

    /**
     * @expectedException \Concise\Validation\DataTypeMismatchException
     * @expectedExceptionMessage Expected regex, but got integer
     */
    public function testDataTypeMismatchExceptionIsThrown()
    {
        $this->dataTypeChecker->check(array('regex'), 123);
    }

    public function testDataTypeMismatchExceptionHasCorrectActualType()
    {
        try {
            $this->dataTypeChecker->check(array('regex'), 123);
        } catch (DataTypeMismatchException $e) {
            $this->assert($e->getActualType(), equals, 'integer');
        }
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage No such class or interface '\Concise\FooBar'
     */
    public function testBadClassName()
    {
        $this->dataTypeChecker->check(array('class'), '\Concise\FooBar');
    }

    public function testInterfaceIsAllowedForClassName()
    {
        $result = $this->dataTypeChecker->check(
            array('class'),
            '\Concise\Mock\MockInterface'
        );
        $this->assert($result, equals, 'Concise\Mock\MockInterface');
    }
}
