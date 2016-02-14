<?php

namespace Concise\Module;

use Concise\Core\DidNotMatchException;
use Concise\Core\SyntaxRenderer;
use Concise\Core\TestCase;

abstract class AbstractModuleTestCase extends TestCase
{
    /**
     * @var AbstractModule
     */
    protected $module;

    public function testExtendsAbstractMatcher()
    {
        $this->assert($this->module)
            ->isAnInstanceOf('\Concise\Module\AbstractModule');
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
            $this->module->setData($args);
            $this->module->$method($syntax, $args);
            $this->fail("Expected assertion to fail.");
        } catch (DidNotMatchException $e) {
            $this->assertSame($failureMessage, $e->getMessage());
        }
    }

    public function testModuleHasAName()
    {
        $this->assertString($this->module->getName())->isNotEmpty;
    }

    protected function expectFailure($message)
    {
        $this->setExpectedException('Exception', $message);
        SyntaxRenderer::$color = false;
    }
}
