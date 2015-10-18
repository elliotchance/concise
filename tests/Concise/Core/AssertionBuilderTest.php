<?php

namespace Concise\Core;

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
            /** @var AssertionBuilder $builder */
            $builder = $this->niceMock(
                '\Concise\Core\AssertionBuilder',
                array($this, 'custom message')
            )
                ->setProperty('lastBuilder', null)
                ->stub('validateLastAssertion')
                ->get();
            $builder->handleFailure(new Exception('foo bar'));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            $this->assert($e->getMessage())->equals('custom message');
        }
    }

    /**
     * @group #306
     */
    public function testDidNotMatchExceptionMessageIfNoCustomFailureMessage()
    {
        try {
            /** @var AssertionBuilder $builder */
            $builder = $this->niceMock(
                '\Concise\Core\AssertionBuilder',
                array($this)
            )
                ->setProperty('lastBuilder', null)
                ->stub('validateLastAssertion')
                ->get();
            $builder->handleFailure(new Exception('foo bar'));
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            $this->assert($e->getMessage())->equals('foo bar');
        }
    }
}
