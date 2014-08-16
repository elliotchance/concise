<?php

namespace Concise\Matcher;

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
}
