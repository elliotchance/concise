<?php

namespace Concise\Mock;

use Concise\TestCase;
use Concise\Services\NumberToTimesConverter;
use Concise\Services\ValueRenderer;
use InvalidArgumentException;
use Exception;
use ReflectionClass;
use Closure;
use Concise\Validation\ArgumentChecker;

class MockBuilder
{
    /**
	 * @var Concise\TestCase
	 */
    protected $testCase;

    /**
	 * @var array
	 */
    protected $rules = array();

    /**
	 * @var bool
	 */
    protected $niceMock;

    /**
	 * The names of the methods to be mocked.
	 * @var array
	 */
    protected $mockedMethods = array();

    /**
	 * The original fully-qualified class name to create the mock from.
	 * @var string
	 */
    protected $className;

    /**
	 * Used internally as the active mocked method when using chained methods to builds the rules for this method.
	 * @var array
	 */
    protected $currentRules = array();

    /**
	 * The arguments associated with this rule.
	 * @var array
	 */
    protected $currentWith = null;

    /**
	 * Constructor arguments.
	 * @var array
	 */
    protected $constructorArgs;

    /**
	 * @var boolean
	 */
    protected $disableConstructor = false;

    /**
     * A list of methods that should be exposed as public.
     * @var array
     */
    protected $expose = array();

    /**
	 * If the current rule is expect()
	 * @var boolean
	 */
    protected $isExpecting = false;

    /**
     * You may set a customer class name for this mock.
     * @var string
     */
    protected $customClassName = '';

    /**
	 * @param string   $className
	 * @param boolean  $niceMock
	 * @param TestCase $testCase
	 * @param array    $constructorArgs
	 */
    public function __construct(TestCase $testCase, $className, $niceMock, array $constructorArgs = array())
    {
        ArgumentChecker::check($className, 'string', 2);
        ArgumentChecker::check($niceMock,  'boolean', 3);

        $this->testCase = $testCase;
        if (!class_exists($className) && !interface_exists($className)) {
            throw new Exception("Class or interface '$className' does not exist.");
        }
        $this->className = $className;
        $this->niceMock = $niceMock;
        $this->constructorArgs = $constructorArgs;
    }

    /**
	 * @param array                 $methods
	 * @param Action\AbstractAction $action
	 * @param integer               $times
	 */
    protected function addRule(array $methods, Action\AbstractAction $action, $times = -1)
    {
        $this->currentRules = $methods;
        foreach ($methods as $method) {
            $this->mockedMethods[] = $method;
            $this->rules[$method] = array();
        }
        $this->setupWith($action, $times);
    }

    protected function reset()
    {
        $this->currentWith = null;
        $this->isExpecting = false;
    }

    /**
	 * @param  array|string $arg
	 * @return MockBuilder
	 */
    public function stub($arg)
    {
        $this->reset();
        if (count(func_get_args()) > 1) {
            $this->addRule(func_get_args(), new Action\ReturnValueAction(array(null)));
            return $this;
        }

        if (is_array($arg)) {
            if (count($arg) === 0) {
                throw new \Exception("stub() called with array must have at least 1 element.");
            }
            foreach ($arg as $method => $value) {
                $this->addRule(array($method), new Action\ReturnValueAction(array($value)));
            }
        } else {
            $this->addRule(array($arg), new Action\ReturnValueAction(array(null)));
        }

        return $this;
    }

    /**
	 * Compiler the mock into a usable instance.
	 * @return object
	 */
    public function get()
    {
        $compiler = new ClassCompiler($this->className, $this->niceMock, $this->constructorArgs, $this->disableConstructor);
        if ($this->customClassName) {
            $compiler->setCustomClassName($this->customClassName);
        }
        $compiler->setRules($this->rules);
        foreach ($this->expose as $method) {
            $compiler->addExpose($method);
        }
        $mockInstance = $compiler->newInstance();
        $this->testCase->addMockInstance($this, $mockInstance);

        return $mockInstance;
    }

    protected function getWithKey()
    {
        return md5(json_encode($this->currentWith));
    }

    /**
	 * @return boolean
	 */
    protected function hasAction($rule)
    {
        if (!array_key_exists($rule, $this->rules)) {
            return false;
        }

        $action = $this->rules[$rule][$this->getWithKey()]['action'];
        if ($action instanceof Action\ReturnValueAction && is_null(current($action->getValue()))) {
            return false;
        }

        return true;
    }

    /**
	 * @param Action\AbstractAction $action
	 * @return MockBuilder
	 */
    protected function setAction(Action\AbstractAction $action)
    {
        foreach ($this->currentRules as $rule) {
            if ($this->hasAction($rule)) {
                throw new Exception("{$rule}() has more than one action attached.");
            }
            $this->rules[$rule][$this->getWithKey()]['action'] = $action;
        }

        return $this;
    }

    protected function methodIsNeverExpected()
    {
        return $this->rules[$this->currentRules[0]][$this->getWithKey()]['times'] === 0;
    }

    /**
	 * @return MockBuilder
	 */
    public function andReturn()
    {
        if ($this->methodIsNeverExpected()) {
            throw new Exception("You cannot assign an action to '{$this->currentRules[0]}()' when it is never expected.");
        }
        $values = func_get_args();

        return $this->setAction(new Action\ReturnValueAction($values));
    }

    /**
	 * @param \Exception $exception
	 * @return MockBuilder
	 */
    public function andThrow(Exception $exception)
    {
        return $this->setAction(new Action\ThrowAction($exception));
    }

    /**
	 * Expect the method to called called exactly once.
	 * @return MockBuilder
	 */
    public function once()
    {
        return $this->exactly(1);
    }

    /**
	 * @param string $method
	 * @return MockBuilder
	 */
    public function expect($method)
    {
        ArgumentChecker::check($method, 'string');

        $this->reset();
        $this->isExpecting = true;
        $this->addRule(array($method), new Action\ReturnValueAction(array(null)));
        $this->once();
        $this->rules[$this->currentRules[0]][$this->getWithKey()]['hasSetTimes'] = false;

        return $this;
    }

    /**
	 * @param string $method
	 * @return MockBuilder
	 */
    public function expects($method)
    {
        return $this->expect($method);
    }

    /**
	 * Expect the method to be called exactly twice.
	 * @return MockBuilder
	 */
    public function twice()
    {
        return $this->exactly(2);
    }

    /**
	 * Expect that the method is never called.
	 * @return MockBuilder
	 */
    public function never()
    {
        return $this->exactly(0);
    }

    /**
	 * @param integer $times
	 * @return MockBuilder
	 */
    public function exactly($times)
    {
        ArgumentChecker::check($times, 'integer');

        $this->rules[$this->currentRules[0]][$this->getWithKey()]['hasSetTimes'] = true;
        if ($times === 0) {
            $this->andReturn(array(null));
        }
        $this->rules[$this->currentRules[0]][$this->getWithKey()]['times'] = $times;

        return $this;
    }

    protected function setupWith(Action\AbstractAction $action, $times)
    {
        foreach ($this->currentRules as $rule) {
            $this->rules[$rule][$this->getWithKey()] = array(
                'action'      => $action,
                'times'       => $times,
                'with'        => $this->currentWith,
                'hasSetTimes' => false,
            );
        }
    }

    /**
	 * Expected arguments when invoking the mock.
	 * @return MockBuilder
	 */
    public function with()
    {
        $this->currentWith = func_get_args();
        if ($this->rules[$this->currentRules[0]][md5('null')]['hasSetTimes']) {
            $renderer = new ValueRenderer();
            $converter = new NumberToTimesConverter();
            $args = $renderer->renderAll($this->currentWith);
            throw new Exception(sprintf("When using with you must specify expecations for each with():\n  ->expects('%s')->with(%s)->%s",
                $this->currentRules[0], $args, $converter->convertToMethod($this->rules[$this->currentRules[0]][md5('null')]['times'])));
        }
        $this->rules[$this->currentRules[0]][md5('null')]['times'] = -1;
        $this->setupWith(new Action\ReturnValueAction(array(null)), $this->isExpecting ? 1 : -1);

        return $this;
    }

    /**
	 * @return array
	 */
    public function getRules()
    {
        return $this->rules;
    }

    protected function isInterface()
    {
        $refClass = new \ReflectionClass($this->className);

        return $refClass->isInterface();
    }

    /**
	 * @return MockBuilder
	 */
    public function disableConstructor()
    {
        if ($this->isInterface()) {
            throw new InvalidArgumentException("You cannot disable the constructor of an interface ({$this->className}).");
        }
        $this->disableConstructor = true;

        return $this;
    }

    public function expose()
    {
        foreach (func_get_args() as $arg) {
            if (!is_array($arg)) {
                $arg = array($arg);
            }
            $this->expose = array_merge($arg, $this->expose);
        }

        return $this;
    }

    /**
	 * @return MockBuilder
	 */
    public function andReturnSelf()
    {
        return $this->setAction(new Action\ReturnSelfAction());
    }

    public function andDo(Closure $action)
    {
        return $this->setAction(new Action\DoAction($action));
    }

    public function setCustomClassName($customClassName)
    {
        ArgumentChecker::check($customClassName, 'string');
        $this->customClassName = $customClassName;

        return $this;
    }

    public function andReturnCallback(Closure $returnCallback)
    {
        return $this->setAction(new Action\ReturnCallbackAction($returnCallback));
    }

    /**
     * @return MockBuilder
     */
    public function andReturnProperty($property)
    {
        ArgumentChecker::check($property, 'string');

        if ($this->isInterface()) {
            throw new InvalidArgumentException("You cannot return a property from an interface ({$this->className}).");
        }

        return $this->setAction(new Action\ReturnPropertyAction($property));
    }
}
