<?php

namespace Concise\Matcher;

class ThrowsExceptionTest extends AbstractExceptionTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new ThrowsException();
    }

    public function exceptionTests()
    {
        $throwNothing = function () {};
        $throwException = function () { throw new \Exception(); };

        return array(
            array($throwNothing,   false),
            array($throwException, true),
        );
    }

    /**
	 * @dataProvider exceptionTests
	 */
    public function testThrows(\Closure $method, $expectSuccess)
    {
        try {
            $this->matcher->match('? throws exception', array($method));
            $success = true;
        } catch (DidNotMatchException $e) {
            $success = false;
        }
        $this->assert($expectSuccess, equals, $success);
    }

    public function testThrowsMessage()
    {
        try {
            $this->matcher->match('? throws exception', array(function () {}));
            $this->fail("Exception was not thrown.");
        } catch (DidNotMatchException $e) {
            $this->assert("Expected exception to be thrown.", equals, $e->getMessage());
        }
    }

}
