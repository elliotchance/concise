<?php

namespace Concise\Modules\Urls;

use Concise\Matcher\AbstractMatcherTestCase;

/**
 * @group matcher
 */
class UrlIsValidTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new UrlIsValid();
    }

    public function testInvalidURL()
    {
        $this->assertFailure(url, 'foo', is_valid);
    }

    public function testValidURL()
    {
        $this->assert(url, 'http://www.google.com', is_valid);
    }

    public function tags()
    {
        return array();
    }
}
