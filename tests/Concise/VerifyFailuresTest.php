<?php

namespace Concise\Mock;

use Colors\Color;
use Concise\TestCase;

class VerifyFailuresTest extends TestCase
{
    protected static $failures = array();

    protected static $expectedFailures = array(
        'testMultipleVerifyFailures' => "2 verify failures:\n\n10 equals 15\n\n15 equals 20",
        'testSingleVerifyFailures' => "1 verify failure:\n\n10 equals 15",
    );

    /**
     * @group #216
     */
    public function testMultipleVerifyFailures()
    {
        $this->verify(10, equals, 15);
        $this->verify(15, equals, 20);
    }

    /**
     * @group #216
     */
    public function testSingleVerifyFailures()
    {
        $this->verify(10, equals, 15);
    }

    protected function onNotSuccessfulTest(\Exception $e)
    {
        $c = new Color();
        self::$failures[] = $this->getName();
        $this->assert(self::$expectedFailures[$this->getName()], equals, $c($e->getMessage())->clean());
    }

    public static function tearDownAfterClass()
    {
        $a = array_keys(self::$expectedFailures);
        $b = self::$failures;
        $testCase = new TestCase();
        $testCase->setUp();
        $testCase->assert(array_diff($a, $b), equals, array_diff($b, $a));
        $testCase->tearDown();
    }
}
