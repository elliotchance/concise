<?php

namespace Concise\Matcher;

/**
 * @group matcher
 */
class UrlHasPartTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new UrlHasPart();
    }

    public function data()
    {
        return array(
            'scheme 1' => array('http://google.com', 'has scheme', 'http', true),
            'scheme 2' => array('http://google.com', 'has scheme', 'https', false),
            'scheme 3' => array('google.com', 'has scheme', '', true),

            'host 1' => array('http://google.com', 'has host', 'google.com', true),
            'host 2' => array('http://google.com', 'has host', 'foo.com', false),
            'host 3' => array('http://?abc', 'has host', '', true),

            'port 1' => array('http://foo:123', 'has port', 123, true),
            'port 2' => array('http://foo:123', 'has port', 456, false),
            'port 3' => array('http://foo:123', 'has port', 0, false),

            'user 1' => array('http://foo@bar', 'has user', 'foo', true),
            'user 2' => array('http://foo@bar', 'has user', 'bar', false),
            'user 3' => array('http://bar.com', 'has user', '', true),

            'pass 1' => array('http://foo:baz@bar', 'has password', 'baz', true),
            'pass 2' => array('http://foo:bar@bar', 'has password', 'baz', false),
            'pass 3' => array('http://bar.com', 'has password', '', true),

            'path 1' => array('http://foo.com/abc', 'has path', '/abc', true),
            'path 2' => array('http://foo.com/abc', 'has path', '/def', false),
            'path 3' => array('http://foo.com', 'has path', '', true),

            'query 1' => array('http://foo.com/abc?foo', 'has query', 'foo', true),
            'query 2' => array('http://foo.com/abc?foo', 'has query', 'bar', false),
            'query 3' => array('http://foo.com', 'has query', '', true),

            'fragment 1' => array('http://foo.com/abc#foo', 'has fragment', 'foo', true),
            'fragment 2' => array('http://foo.com/abc#foo', 'has fragment', 'bar', false),
            'fragment 3' => array('http://foo.com', 'has fragment', '', true),
        );
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

    public function tags()
    {
        return array(Tag::URLS);
    }
}
