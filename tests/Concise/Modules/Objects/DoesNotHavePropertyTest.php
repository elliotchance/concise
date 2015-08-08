<?php

namespace Concise\Modules\Objects;

use Concise\Matcher\AbstractMatcherTestCase;
use stdClass;

/**
 * @group matcher
 */
class DoesNotHavePropertyTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new DoesNotHaveProperty();
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
}
