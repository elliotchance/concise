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
        $this->assert("123")->matchesRegularExpression('/\\d+/');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testMatchesRegularExpressionFailure()
    {
        $this->assert("abc")->matchesRegularExpression('/\\d+/');
    }

    public function testDoesNotMatchRegularExpression()
    {
        $this->assert("abc")->doesNotMatchRegex('/^f/');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testDoesNotMatchRegularExpressionFailure()
    {
        $this->assert("foo")->doesNotMatchRegex('/^f/');
    }
}
