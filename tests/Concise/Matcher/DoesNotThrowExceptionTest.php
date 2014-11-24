<?php

namespace Concise\Matcher;

/**
 * @group matcher
 */
class DoesNotThrowExceptionTest extends AbstractExceptionTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new DoesNotThrowException();
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
    public function testDoesNotThrow(\Closure $method, $expectSuccess)
    {
        $success = false;
        try {
            $success = $this->matcher->match('? does not throw exception', array($method));
        } catch (DidNotMatchException $e) {
            $success = false;
        }
        $this->assert($expectSuccess, equals, !$success);
    }

    public function testDoesNotThrowMessage()
    {
        try {
            $this->matcher->match('? does not throw exception', array(function () { throw new \Exception(); }));
            $this->fail("Exception was not thrown.");
        } catch (DidNotMatchException $e) {
            $this->assert("Expected exception not to be thrown.", equals, $e->getMessage());
        }
    }

    public function tags()
    {
        return array(Tag::EXCEPTIONS);
    }
}
