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
        $this->aassert("123")->matchesRegularExpression('/\\d+/');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testMatchesRegularExpressionFailure()
    {
        $this->aassert("abc")->matchesRegularExpression('/\\d+/');
    }

    public function testDoesNotMatchRegularExpression()
    {
        $this->aassert("abc")->doesNotMatchRegex('/^f/');
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testDoesNotMatchRegularExpressionFailure()
    {
        $this->aassert("foo")->doesNotMatchRegex('/^f/');
    }
}
