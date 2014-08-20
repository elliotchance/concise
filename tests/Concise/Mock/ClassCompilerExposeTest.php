<?php

namespace Concise\Mock;

use \Concise\TestCase;
use \Concise\Mock\Action\ReturnValueAction;

class ClassCompilerMock3
{
    protected function hidden()
    {
        return 'foo';
    }

    protected function hidden2()
    {
        return 'foo';
    }

    protected function hidden3($a)
    {
        return $a * 2;
    }

    private function superSecret()
    {
    }
}

class ClassCompilerExposeTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->compiler = new ClassCompiler('\Concise\Mock\ClassCompilerMock3', true);
    }

    public function testAMethodCanBeExposed()
    {
        $this->compiler->addExpose('hidden');
        $instance = $this->compiler->newInstance();
        $this->assert($instance->hidden(), equals, 'foo');
    }

    protected function setRulesForExposure()
    {
        $this->compiler->setRules(array(
            'hidden' => array(
                array(
                    'action' => new ReturnValueAction(array('bar')),
                    'with'   => null,
                ),
            ),
        ));
    }

    public function testAMethodThatHasARuleCanBeExposed()
    {
        $this->setRulesForExposure();
        $this->compiler->addExpose('hidden');
        $instance = $this->compiler->newInstance();
        $this->assert($instance->hidden(), equals, 'bar');
    }

    public function testAProtectedMethodMustStayProtected()
    {
        $instance = $this->compiler->newInstance();
        $reflectionClass = new \ReflectionClass(get_class($instance));
        $this->assert($reflectionClass->getMethod('hidden')->isPublic(), is_false);
    }

    public function testExposingOneMethodWillNotExposeThemAll()
    {
        $this->compiler->addExpose('hidden');
        $instance = $this->compiler->newInstance();
        $reflectionClass = new \ReflectionClass(get_class($instance));
        $this->assert($reflectionClass->getMethod('hidden2')->isPublic(), is_false);
    }

    public function testAddingARuleToAMethodWillNotExposeThemAll()
    {
        $this->setRulesForExposure();
        $instance = $this->compiler->newInstance();
        $reflectionClass = new \ReflectionClass(get_class($instance));
        $this->assert($reflectionClass->getMethod('hidden2')->isPublic(), is_false);
    }

    public function testAddingARuleToAMethodWillNotExposeIt()
    {
        $this->setRulesForExposure();
        $instance = $this->compiler->newInstance();
        $reflectionClass = new \ReflectionClass(get_class($instance));
        $this->assert($reflectionClass->getMethod('hidden')->isPublic(), is_false);
    }

    public function testMocksThatAreNotNiceWillNotExposeAMethod()
    {
        $this->compiler = new ClassCompiler('\Concise\Mock\ClassCompilerMock3');
        $instance = $this->compiler->newInstance();
        $reflectionClass = new \ReflectionClass(get_class($instance));
        $this->assert($reflectionClass->getMethod('hidden')->isPublic(), is_false);
    }

    public function testTwoMethodsCanBeExposed()
    {
        $this->compiler->addExpose('hidden');
        $this->compiler->addExpose('hidden2');
        $instance = $this->compiler->newInstance();
        $this->assert($instance->hidden(), equals, 'foo');
    }

    public function testExposingAMethodRespectsArguments()
    {
        $this->compiler->addExpose('hidden3');
        $instance = $this->compiler->newInstance();
        $this->assert($instance->hidden3(3), equals, 6);
    }

    /**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage Method Concise\Mock\ClassCompilerMock3::foo() does not exist.
	 */
    public function testAnExceptionIsThrownIfTheMethodDoesNotExist()
    {
        $this->compiler->addExpose('foo');
    }

    /**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage Method Concise\Mock\ClassCompilerMock3::superSecret() cannot be mocked because it it private.
	 */
    public function testTryingToExposeAPrivateMethodThrowsException()
    {
        $this->compiler->addExpose('superSecret');
    }
}
