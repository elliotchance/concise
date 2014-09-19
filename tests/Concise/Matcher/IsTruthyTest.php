<?php

namespace Concise\Matcher;

class IsTruthyTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsTruthy();
    }

    public function testFalseIsNotTruthy()
    {
        $this->assertFailure(false, is_truthy);
    }
}
