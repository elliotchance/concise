<?php

namespace Concise\Modules\Objects;

use Concise\Matcher\AbstractMatcherTestCase;
use stdClass;

/**
 * @group matcher
 */
class HasPropertyWithExactValueTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new HasPropertyWithExactValue();
    }

    public function testObjectDoesNotHaveAProperty()
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
}
