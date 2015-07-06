<?php

namespace Concise\Matcher;

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
class HasPropertyWithValueTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new HasPropertyWithValue();
    }

    public function testObjectDoesNotHaveAProperty()
    {
        $obj = new \stdClass();
        $this->assertFailure($obj, has_property, 'foo', with_value, 'bar');
    }

    public function testObjectHasPropertyWithCorrectValue()
    {
        $obj = new \stdClass();
        $obj->foo = 'bar';
        $this->assert($obj, has_property, 'foo', with_value, 'bar');
    }

    public function testObjectHasPropertyWithIncorrectValue()
    {
        $obj = new \stdClass();
        $obj->foo = 'baz';
        $this->assertFailure($obj, has_property, 'foo', with_value, 'bar');
    }

    public function testObjectHasPropertyWithCorrectNonExactValue()
    {
        $obj = new \stdClass();
        $obj->foo = 123;
        $this->assert($obj, has_property, 'foo', with_value, '123');
    }

    public function tags()
    {
        return array(Tag::OBJECTS);
    }

    public function testObjectHasSecretPropertyWithCorrectValue()
    {
        $obj = new SecretProperties();
        $this->assert($obj, has_property, 'a', with_value, 'foo');
    }

    public function testObjectHasSecretPropertyWithIncorrectValue()
    {
        $obj = new SecretProperties();
        $this->assertFailure($obj, has_property, 'a', with_value, 'bar');
    }
}
