<?php

namespace Concise\Core;

use Concise\Module\BasicModule;
use Exception;
use PHPUnit_Framework_AssertionFailedError;

class AssertionBuilderTest extends TestCase
{
    /**
     * @group #306
     */
    public function testHandleFailureWillUseCustomFailureMessageFirst()
    {
        try {
            $builder = $this->getBuilder(array($this, 'custom message'));
            $builder->handleFailure(
                new Exception('foo bar'),
                $this->getBasicModule()
            );
        } catch (DidNotMatchException $e) {
            $this->assert($e->getMessage())->equals('custom message');
        }
    }

    /**
     * @group #306
     */
    public function testDidNotMatchExceptionMessageIfNoCustomFailureMessage()
    {
        try {
            $builder = $this->getBuilder(array($this));
            $builder->handleFailure(
                new Exception('foo bar'),
                $this->getBasicModule()
            );
        } catch (DidNotMatchException $e) {
            $this->assert($e->getMessage())->equals('foo bar');
        }
    }

    /**
     * @group #306
     */
    public function testWillRenderSyntaxIsNoOtherMessageCanBeFound()
    {
        try {
            $builder = $this->getBuilder(array($this));
            $builder->handleFailure(
                new DidNotMatchException(),
                $this->getBasicModule()
            );
        } catch (DidNotMatchException $e) {
            $this->assert($e->getMessage())->equals('my syntax');
        }
    }

    /**
     * @return BasicModule
     */
    protected function getBasicModule()
    {
        $module = new BasicModule();
        $module->syntax = new Syntax('my syntax');
        $module->data = array();
        return $module;
    }

    /**
     * @return AssertionBuilder
     * @throws Exception
     */
    protected function getBuilder(array $constructorArgs)
    {
        /** @var AssertionBuilder $builder */
        $builder = $this->niceMock(
            '\Concise\Core\AssertionBuilder',
            $constructorArgs
        )
            ->setProperty('lastBuilder', null)
            ->stub('validateLastAssertion')
            ->get();
        return $builder;
    }
}
