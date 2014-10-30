<?php

namespace Concise\Matcher;

class UrlHasSchemeTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new UrlHasScheme();
    }

    public function testUrlHasScheme()
    {
        $this->assert(url, 'http://google.com', has_scheme, 'http');
    }
}
