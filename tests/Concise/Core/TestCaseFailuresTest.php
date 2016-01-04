<?php

namespace Concise\Core;

use Exception;

class TestCaseFailuresTest extends TestCase
{
    protected static $failures = array();

    protected static $expectedFailures = array(
        'testNoSuchAssertionAsLast' => 'No such syntax "? foo bar"',
    );

    public function testNoSuchAssertionAsLast()
    {
        $this->assert('a')->fooBar;
    }

    protected function onNotSuccessfulTest(Exception $e)
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
