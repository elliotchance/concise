<?php

namespace Concise\Assertion;

use Concise\TestCase;

class AssertionBuilderTest extends TestCase
{
    public function data()
    {
        return array(
            array(
                array(array(null, 123)),
                array(123),
                '?'
            ),
            array(
                array(array('foo', 123)),
                array(123),
                'foo ?'
            ),
            array(
                array(array(null, 123), array('equals')),
                array(123),
                '? equals'
            ),
            array(
                array(array(null, 'a'), array('equals', 'b')),
                array('a', 'b'),
                '? equals ?'
            ),
            array(
                array(array('url', 'http'), array('is valid')),
                array('http'),
                'url ? is valid'
            ),
            array(
                array(array('url', 'http'), array('is valid', 456)),
                array('http', 456),
                'url ? is valid ?'
            ),
            array(
                array(array(null, 0), array('equals', 10), array('between', 5)),
                array(0, 10, 5),
                '? equals ? between ?'
            ),
        );
    }

    /**
     * @dataProvider data
     */
    public function testData(array $adds, array $data)
    {
        $builder = new AssertionBuilder();
        foreach ($adds as $add) {
            call_user_func_array(array($builder, 'add'), $add);
        }
        $this->assert($builder->getData(), equals, $data);
    }

    /**
     * @dataProvider data
     */
    public function testSyntax(array $adds, array $data, $syntax)
    {
        $builder = new AssertionBuilder();
        foreach ($adds as $add) {
            call_user_func_array(array($builder, 'add'), $add);
        }
        $this->assert($builder->getSyntax(), equals, $syntax);
    }
}
