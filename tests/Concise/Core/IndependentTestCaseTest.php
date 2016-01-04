<?php

namespace Concise\Core;

class IndependentTestCaseTest extends TestCase
{
    public function testItIsATestCase()
    {
        $this->assert(new IndependentTestCase())
            ->isAnInstanceOf('\Concise\Core\TestCase');
    }
}
