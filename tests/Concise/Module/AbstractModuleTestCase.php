<?php

namespace Concise\Module;

use Concise\Core\AssertionBuilder;
use Concise\Core\DidNotMatchException;
use Concise\TestCase;
use PHPUnit_Framework_AssertionFailedError;

abstract class AbstractModuleTestCase extends TestCase
{
    /**
     * @var AbstractModule
     */
    protected $matcher;

    public function testExtendsAbstractMatcher()
    {
        $this->assert(
            $this->matcher,
            is_instance_of,
            '\Concise\Module\AbstractModule'
        );
    }

    protected function createStdClassThatCanBeCastToString($value)
    {
        return $this->mock()->stub(array('__toString' => $value))->get();
    }

    /**
     * @param string $syntax
     */
    protected function assertMatcherFailureMessage(
        $syntax,
        array $args,
        $failureMessage,
        $method = 'match'
    ) {
        try {
            $this->matcher->setData($args);
            $this->matcher->$method($syntax, $args);
            $this->fail("Expected assertion to fail.");
        } catch (DidNotMatchException $e) {
            $this->assertSame($failureMessage, $e->getMessage());
        }
    }

    protected function assertFailure()
    {
        try {
            call_user_func_array(array($this, 'assert'), func_get_args());
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            $this->assert(true);

            return;
        }
        $this->fail("Core did not fail.");
    }

    protected function aassertFailure(AssertionBuilder $assertion)
    {
        try {
            $this->performCurrentAssertion();
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            $this->assert(true);

            return;
        }
        $this->fail("Core did not fail.");
    }

    public function testModuleHasAName()
    {
        $this->assert($this->matcher->getName(), is_not_blank);
    }
}
