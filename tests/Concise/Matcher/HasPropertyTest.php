<?php

namespace Concise\Matcher;

class HasPropertyTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new HasProperty();
    }

    public function testObjectDoesNotHaveAProperty()
    {
        $obj = new \stdClass();
        $this->assertFailure($obj, has_property, 'foo');
    }

    public function testObjectDoesHaveAProperty()
    {
        $obj = new \stdClass();
        $obj->foo = 'bar';
        $this->assert($obj, has_property, 'foo');
    }

    public function testObjectDoesHaveAPropertyWithAFalsyValue()
    {
        $obj = new \stdClass();
        $obj->foo = null;
        $this->assert($obj, has_property, 'foo');
    }
}
