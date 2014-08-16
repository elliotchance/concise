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
}
