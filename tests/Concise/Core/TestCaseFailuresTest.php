<?php

namespace Concise\Core;

use Throwable;

class TestCaseFailuresTest extends TestCase
{
    protected static $failures = array();

    protected static $expectedFailures = array(
        'testNoSuchAssertionAsLast' => 'No such syntax "? foo bar"',
        'testCustomMessageWithAssertionFailure' => 'Something: true equals false',
    );

    public function testNoSuchAssertionAsLast()
    {
        $this->assert('a')->fooBar;
    }

    public function testCustomMessageWithAssertionFailure()
    {
        SyntaxRenderer::$color = false;
        $this->assert('Something', true)->equals(false);
    }

    protected function onNotSuccessfulTest(Throwable $e)
    {
        self::$failures[] = $this->getName();
        $this->assert(self::$expectedFailures[$this->getName()])
            ->equals($e->getMessage());
    }

    public static function tearDownAfterClass()
    {
        $a = array_keys(self::$expectedFailures);
        $b = self::$failures;
        $testCase = new IndependentTestCase();
        $testCase->setUp();
        $testCase->assert(array_diff($a, $b))->equals(array_diff($b, $a));
        $testCase->tearDown();
    }
}
