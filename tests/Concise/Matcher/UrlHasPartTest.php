<?php

namespace Concise\Matcher;

class UrlHasPartTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new UrlHasPart();
    }

    public function data()
    {
        return [
            'has scheme 1' => ['http://google.com', 'has scheme', 'http', true],
            'has scheme 2' => ['http://google.com', 'has scheme', 'https', false],
            'has scheme 3' => ['google.com', 'has scheme', '', true],

            'has host 1' => ['http://google.com', 'has host', 'google.com', true],
            'has host 2' => ['http://google.com', 'has host', 'foo.com', false],
            'has host 3' => ['http://?abc', 'has host', '', true],

            'has port 1' => ['http://foo:123', 'has port', 123, true],
            'has port 2' => ['http://foo:123', 'has port', 456, false],
            'has port 3' => ['http://foo:123', 'has port', 0, false],

            'has user 1' => ['http://foo@bar', 'has user', 'foo', true],
            'has user 2' => ['http://foo@bar', 'has user', 'bar', false],
            'has user 3' => ['http://bar.com', 'has user', '', true],

            'has pass 1' => ['http://foo:baz@bar', 'has password', 'baz', true],
            'has pass 2' => ['http://foo:bar@bar', 'has password', 'baz', false],
            'has pass 3' => ['http://bar.com', 'has password', '', true],
        ];
    }

    /**
     * @dataProvider data
     */
    public function testUrl($url, $test, $value, $passes)
    {
        if ($passes) {
            $this->assert(url, $url, $test, $value);
        } else {
            $this->assertFailure(url, $url, $test, $value);
        }
    }
}
