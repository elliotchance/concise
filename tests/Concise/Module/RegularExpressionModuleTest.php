<?php

namespace Concise\Module;

/**
 * @group matcher
 */
class RegularExpressionModuleTest extends AbstractModuleTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new RegularExpressionModule();
    }

    public function testMatchesRegularExpression()
    {
        $this->assertString("123")->matches('/\\d+/');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testMatchesRegularExpressionFailure()
    {
        $this->assertString("abc")->matches('/\\d+/');
    }

    public function testDoesNotMatchRegularExpression()
    {
        $this->assertString("abc")->doesNotMatch('/^f/');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testDoesNotMatchRegularExpressionFailure()
    {
        $this->assertString("foo")->doesNotMatch('/^f/');
    }
}
