<?php

namespace Concise\Mock;

use Colors\Color;
use Concise\Core\IndependentTestCase;
use Concise\Core\TestCase;
use Throwable;

class VerifyFailuresTest extends TestCase
{
    protected static $failures = array();

    protected static $expectedFailures = array(
        'testMultipleVerifyFailures' => "2 verify failures:\n\n10 equals 15\n\n15 equals 20",
        'testSingleVerifyFailures' => "1 verify failure:\n\n10 equals 15",
        'testWillNotCallBadMethodCallExceptionIsPrefixedWithVerify' => "1 verify failure:\n\nNo such syntax \"something ?\"",
        'testVerifyPrefixIsNotCaseSensitive' => "1 verify failure:\n\nNo such syntax \"something ?\"",
    );

    protected static $didRun = array();

    public function setUp()
    {
        parent::setUp();
        self::$didRun[] = $this->getName();
    }

    /**
     * @group #216
     */
    public function testMultipleVerifyFailures()
    {
        $this->verify(10)->equals(15);
        $this->verify(15)->equals(20);
    }

    /**
     * @group #216
     */
    public function testSingleVerifyFailures()
    {
        $this->verify(10)->equals(15);
    }

    /**
     * @see TestCaseTest::testWillNotCallBadMethodCallExceptionIsPrefixedWithAssert().
     * @group #317
     */
    public function testWillNotCallBadMethodCallExceptionIsPrefixedWithVerify()
    {
        $this->verifySomething(123);
    }

    /**
     * @see TestCaseTest::testAssertPrefixIsNotCaseSensitive().
     * @group #317
     */
    public function testVerifyPrefixIsNotCaseSensitive()
    {
        $this->VerifySomething(123);
    }

    protected function onNotSuccessfulTest(Throwable $e)
    {
        $c = new Color();
        self::$failures[] = $this->getName();
        $this->assert(self::$expectedFailures[$this->getName()])
            ->equals($c($e->getMessage())->clean());
    }

    public static function tearDownAfterClass()
    {
        $a = self::$didRun;
        $b = self::$failures;

        $testCase = new IndependentTestCase();
        $testCase->setUp();
        $testCase->assert(array_diff($a, $b))->equals(array_diff($b, $a));
        $testCase->tearDown();
    }
}
