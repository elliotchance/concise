<?php

namespace Concise\Services;

class MatcherSyntaxAndDescriptionTest extends \Concise\TestCase
{
    protected function assertProcess(array $expected, array $actual)
    {
        $service = new MatcherSyntaxAndDescription();
        $result = $service->process($expected);
        $this->assertSame($actual, $result);
    }

    public function testNoDescriptions()
    {
        $this->assertProcess(
            array(
                '? equals ?',
                '? is equal to ?'
            ),
            array(
                '? equals ?' => null,
                '? is equal to ?' => null
            )
        );
    }

    public function testAllDescriptions()
    {
        $this->assertProcess(
            array(
                '? equals ?' => 'foo',
                '? is equal to ?' => 'bar'
            ),
            array(
                '? equals ?' => 'foo',
                '? is equal to ?' => 'bar'
            )
        );
    }

    public function testMixedDescriptions()
    {
        $this->assertProcess(
            array(
                '? equals ?',
                '? is equal to ?' => 'bar'
            ),
            array(
                '? equals ?' => null,
                '? is equal to ?' => 'bar'
            )
        );
    }
}
