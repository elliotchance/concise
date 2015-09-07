<?php

namespace Concise\Module;

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
class ObjectModuleTest extends AbstractModuleTestCase
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

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testObjectDoesHaveAProperty()
    {
        $obj = new stdClass();
        $obj->foo = 'bar';
        $this->aassert($obj)->doesNotHaveProperty('foo');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testObjectDoesHaveAPropertyWithAFalsyValue()
    {
        $obj = new stdClass();
        $obj->foo = null;
        $this->aassert($obj)->doesNotHaveProperty('foo');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testObjectDoesNotHaveAProperty1()
    {
        $this->aassert($this->obj)->hasProperty('foo');
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
}
