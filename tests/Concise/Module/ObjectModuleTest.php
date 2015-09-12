<?php

namespace Concise\Module;

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
        $this->assert($obj)->doesNotHaveProperty('foo');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testObjectDoesHaveAProperty()
    {
        $obj = new stdClass();
        $obj->foo = 'bar';
        $this->assert($obj)->doesNotHaveProperty('foo');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testObjectDoesHaveAPropertyWithAFalsyValue()
    {
        $obj = new stdClass();
        $obj->foo = null;
        $this->assert($obj)->doesNotHaveProperty('foo');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testObjectDoesNotHaveAProperty1()
    {
        $this->assert($this->obj)->hasProperty('foo');
    }

    public function testObjectDoesHaveAProperty1()
    {
        $this->obj->foo = 'bar';
        $this->assert($this->obj)->hasProperty('foo');
    }

    public function testObjectDoesHaveAPropertyWithAFalsyValue1()
    {
        $this->obj->foo = null;
        $this->assert($this->obj)->hasProperty('foo');
    }
}
