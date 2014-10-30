<?php

namespace Concise\Matcher;

class UrlHasPartTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new UrlHasPart();
    }

    public function testUrlHasScheme()
    {
        $this->assert(url, 'http://google.com', has_scheme, 'http');
    }

    public function testUrlDoesNotHaveScheme()
    {
        $this->assertFailure(url, 'http://google.com', has_scheme, 'https');
    }

    public function testUrlHasHost()
    {
        $this->assert(url, 'http://google.com', has_host, 'google.com');
    }

    public function testUrlDoesNotHaveHost()
    {
        $this->assertFailure(url, 'http://google.com', has_host, 'foo.com');
    }
}
