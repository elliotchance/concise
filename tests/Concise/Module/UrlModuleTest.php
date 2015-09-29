<?php

namespace Concise\Module;

/**
 * @group matcher
 */
class UrlModuleTest extends AbstractModuleTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->module = new UrlModule();
    }

    public function data()
    {
        return array(
            'scheme 1' => array(
                'http://google.com',
                'hasScheme',
                'http',
                true
            ),
            'scheme 2' => array(
                'http://google.com',
                'hasScheme',
                'https',
                false
            ),
            'scheme 3' => array('google.com', 'has scheme', '', true),
            'host 1' => array(
                'http://google.com',
                'hasHost',
                'google.com',
                true
            ),
            'host 2' => array(
                'http://google.com',
                'hasHost',
                'foo.com',
                false
            ),
            'host 3' => array('http://?abc', 'hasHost', '', true),
            'port 1' => array('http://foo:123', 'hasPort', 123, true),
            'port 2' => array('http://foo:123', 'hasPort', 456, false),
            'port 3' => array('http://foo:123', 'hasPort', 0, false),
            'user 1' => array('http://foo@bar', 'hasUser', 'foo', true),
            'user 2' => array('http://foo@bar', 'hasUser', 'bar', false),
            'user 3' => array('http://bar.com', 'hasUser', '', true),
            'pass 1' => array(
                'http://foo:baz@bar',
                'hasPassword',
                'baz',
                true
            ),
            'pass 2' => array(
                'http://foo:bar@bar',
                'hasPassword',
                'baz',
                false
            ),
            'pass 3' => array('http://bar.com', 'hasPassword', '', true),
            'path 1' => array('http://foo.com/abc', 'hasPath', '/abc', true),
            'path 2' => array('http://foo.com/abc', 'hasPath', '/def', false),
            'path 3' => array('http://foo.com', 'hasPath', '', true),
            'query 1' => array(
                'http://foo.com/abc?foo',
                'hasQuery',
                'foo',
                true
            ),
            'query 2' => array(
                'http://foo.com/abc?foo',
                'hasQuery',
                'bar',
                false
            ),
            'query 3' => array('http://foo.com', 'hasQuery', '', true),
            'fragment 1' => array(
                'http://foo.com/abc#foo',
                'hasFragment',
                'foo',
                true
            ),
            'fragment 2' => array(
                'http://foo.com/abc#foo',
                'hasFragment',
                'bar',
                false
            ),
            'fragment 3' => array('http://foo.com', 'hasFragment', '', true),
        );
    }

    /**
     * @dataProvider data
     */
    public function testUrl($url, $test, $value, $passes)
    {
        if (!$passes) {
            $this->setExpectedException('\Concise\Core\DidNotMatchException');
        }
        $this->assertUrl($url)->$test($value);
    }

    /**
     * @expectedException \Concise\Core\DidNotMatchException
     */
    public function testInvalidURL()
    {
        $this->assertUrl('foo')->isValid;
    }

    public function testValidURL()
    {
        $this->assertUrl('http://www.google.com')->isValid;
    }
}
