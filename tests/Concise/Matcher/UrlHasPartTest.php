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

    public function testUrlHasDomain()
    {
        $this->assert(url, 'http://google.com', has_domain, 'google.com');
    }
}
