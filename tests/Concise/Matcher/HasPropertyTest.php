<?php

namespace Concise\Matcher;

use stdClass;

/**
 * @group matcher
 */
class HasPropertyTest extends AbstractNestedMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new HasProperty();
        $this->obj = new stdClass();
    }

    public function testObjectDoesNotHaveAProperty()
    {
        $this->assertFailure($this->obj, has_property, 'foo');
    }

    public function testObjectDoesHaveAProperty()
    {
        $this->obj->foo = 'bar';
        $this->assert($this->obj, has_property, 'foo');
    }

    public function testObjectDoesHaveAPropertyWithAFalsyValue()
    {
        $this->obj->foo = null;
        $this->assert($this->obj, has_property, 'foo');
    }

    public function tags()
    {
        return array(Tag::OBJECTS);
    }

    /**
     * @group #219
     */
    public function testNestedAssertionSuccess()
    {
        $this->obj->foo = 'bar';
        $this->assert($this->assert($this->obj, has_property, 'foo'), exactly_equals, 'bar');
    }

    /**
     * @group #219
     */
    public function testNestedAssertionFailure()
    {
        $this->obj->foo = 'bar';
        $this->assertFailure($this->assert($this->obj, has_property, 'foo'), exactly_equals, 'baz');
    }
}
