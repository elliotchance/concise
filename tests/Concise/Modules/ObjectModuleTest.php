<?php

namespace Concise\Modules;

use Concise\Matcher\AbstractMatcherTestCase;
use stdClass;

class SecretProperties
{
    public function __get($name)
    {
        return "foo";
    }
}

/**
 * @group matcher
 */
class ObjectModuleTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new ObjectModule();
        $this->obj = new stdClass();
    }

    public function testObjectDoesNotHaveAProperty()
    {
        $obj = new stdClass();
        $this->assert($obj, does_not_have_property, 'foo');
    }

    public function testObjectDoesHaveAProperty()
    {
        $obj = new stdClass();
        $obj->foo = 'bar';
        $this->assertFailure($obj, does_not_have_property, 'foo');
    }

    public function testObjectDoesHaveAPropertyWithAFalsyValue()
    {
        $obj = new stdClass();
        $obj->foo = null;
        $this->assertFailure($obj, does_not_have_property, 'foo');
    }

    public function testObjectDoesNotHaveAProperty1()
    {
        $this->assertFailure($this->obj, has_property, 'foo');
    }

    public function testObjectDoesHaveAProperty1()
    {
        $this->obj->foo = 'bar';
        $this->assert($this->obj, has_property, 'foo');
    }

    public function testObjectDoesHaveAPropertyWithAFalsyValue1()
    {
        $this->obj->foo = null;
        $this->assert($this->obj, has_property, 'foo');
    }

    /**
     * @group #219
     */
    public function testNestedAssertionSuccess()
    {
        $this->obj->foo = 'bar';
        $this->assert(
            $this->assert($this->obj, has_property, 'foo'),
            exactly_equals,
            'bar'
        );
    }

    /**
     * @group #219
     */
    public function testNestedAssertionFailure()
    {
        $this->obj->foo = 'bar';
        $this->assertFailure(
            $this->assert($this->obj, has_property, 'foo'),
            exactly_equals,
            'baz'
        );
    }

    public function testObjectDoesNotHaveAProperty2()
    {
        $obj = new stdClass();
        $this->assertFailure(
            $obj,
            has_property,
            'foo',
            with_exact_value,
            'bar'
        );
    }

    public function testObjectHasPropertyWithCorrectValue()
    {
        $obj = new stdClass();
        $obj->foo = 'bar';
        $this->assert($obj, has_property, 'foo', with_exact_value, 'bar');
    }

    public function testObjectHasPropertyWithIncorrectValue()
    {
        $obj = new stdClass();
        $obj->foo = 'baz';
        $this->assertFailure(
            $obj,
            has_property,
            'foo',
            with_exact_value,
            'bar'
        );
    }

    public function testObjectHasPropertyWithCorrectNonExactValue()
    {
        $obj = new stdClass();
        $obj->foo = 123;
        $this->assertFailure(
            $obj,
            has_property,
            'foo',
            with_exact_value,
            '123'
        );
    }

    public function testObjectHasSecretPropertyWithCorrectValue()
    {
        $obj = new SecretProperties();
        $this->assert($obj, has_property, 'a', with_exact_value, 'foo');
    }

    public function testObjectHasSecretPropertyWithIncorrectValue()
    {
        $obj = new SecretProperties();
        $this->assertFailure($obj, has_property, 'a', with_exact_value, 'bar');
    }

    public function testObjectDoesNotHaveAProperty3()
    {
        $obj = new stdClass();
        $this->assertFailure($obj, has_property, 'foo', with_value, 'bar');
    }

    public function testObjectHasPropertyWithCorrectValue1()
    {
        $obj = new stdClass();
        $obj->foo = 'bar';
        $this->assert($obj, has_property, 'foo', with_value, 'bar');
    }

    public function testObjectHasPropertyWithIncorrectValue1()
    {
        $obj = new stdClass();
        $obj->foo = 'baz';
        $this->assertFailure($obj, has_property, 'foo', with_value, 'bar');
    }

    public function testObjectHasPropertyWithCorrectNonExactValue1()
    {
        $obj = new stdClass();
        $obj->foo = 123;
        $this->assert($obj, has_property, 'foo', with_value, '123');
    }

    public function testObjectHasSecretPropertyWithCorrectValue1()
    {
        $obj = new SecretProperties();
        $this->assert($obj, has_property, 'a', with_value, 'foo');
    }

    public function testObjectHasSecretPropertyWithIncorrectValue1()
    {
        $obj = new SecretProperties();
        $this->assertFailure($obj, has_property, 'a', with_value, 'bar');
    }
}
