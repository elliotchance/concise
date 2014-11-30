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
	 * @var TestCase
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
	 * Used internally as the active mocked method when using chained methods to builds the rules
     * for this method.
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
     * @param TestCase $testCase
     * @param string $className
     * @param boolean $niceMock
     * @param array $constructorArgs
     * @throws \Exception
     */
    public function __construct(TestCase $testCase, $className, $niceMock,
        array $constructorArgs = array())
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
     * @throws \Exception
     * @return MockBuilder
     */
    public function stub($arg)
    {
        $this->reset();
        if (is_array($arg)) {
            if (count($arg) === 0) {
                throw new Exception("stub() called with array must have at least 1 element.");
            }
            foreach ($arg as $method => $value) {
                $this->addRule(array($method), new Action\ReturnValueAction(array($value)));
            }
        } else {
            $this->addRule(func_get_args(), new Action\ReturnValueAction(array(null)));
        }

        return $this;
    }

    /**
	 * Compiler the mock into a usable instance.
	 * @return object
	 */
    public function get()
    {
        $compiler = new ClassCompiler($this->className, $this->niceMock, $this->constructorArgs,
            $this->disableConstructor);
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
        $action = $this->rules[$rule][$this->getWithKey()]['action'];
        if ($action instanceof Action\ReturnValueAction && is_null(current($action->getValue()))) {
            return false;
        }

        return true;
    }

    /**
     * @param Action\AbstractAction $action
     * @throws \Exception
     * @return MockBuilder
     */
    protected function setAction(Action\AbstractAction $action)
    {
        foreach ($this->currentRules as $rule) {
            if ($this->methodIsNeverExpected($rule)) {
                $message = "You cannot assign an action to '{$rule}()' when it is never expected.";
                throw new Exception($message);
            }
            if ($this->hasAction($rule)) {
                throw new Exception("{$rule}() has more than one action attached.");
            }
            $this->rules[$rule][$this->getWithKey()]['action'] = $action;
        }

        return $this;
    }

    /**
     * @param string $rule
     * @return bool
     */
    protected function methodIsNeverExpected($rule)
    {
        return $this->rules[$rule][$this->getWithKey()]['times'] === 0;
    }

    /**
     * @throws \Exception
     * @return MockBuilder
     */
    public function andReturn()
    {
        return $this->setAction(new Action\ReturnValueAction(func_get_args()));
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
        $this->addRule(func_get_args(), new Action\ReturnValueAction(array(null)));
        $this->once();
        foreach (func_get_args() as $method) {
            $this->rules[$method][$this->getWithKey()]['hasSetTimes'] = false;
        }

        return $this;
    }

    /**
	 * @return MockBuilder
	 */
    public function expects()
    {
        return call_user_func_array(array($this, 'expect'), func_get_args());
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

        foreach ($this->currentRules as $rule) {
            $this->rules[$rule][$this->getWithKey()]['hasSetTimes'] = true;
            $this->rules[$rule][$this->getWithKey()]['times'] = $times;
        }

        return $this;
    }

    /**
     * @param integer $times
     */
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
     * @throws \Exception
     * @return MockBuilder
     */
    public function with()
    {
        $this->currentWith = func_get_args();
        foreach ($this->currentRules as $rule) {
            if ($this->rules[$rule][md5('null')]['hasSetTimes']) {
                $renderer = new ValueRenderer();
                $converter = new NumberToTimesConverter();
                $args = $renderer->renderAll($this->currentWith);
                $times = $this->rules[$rule][md5('null')]['times'];
                $convertToMethod = $converter->convertToMethod($times);
                throw new Exception(sprintf("%s:\n  ->expects('%s')->with(%s)->%s",
                        "When using with you must specify expectations for each with()",
                        $rule, $args, $convertToMethod));
            }
            $this->rules[$rule][md5('null')]['times'] = -1;
        }
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
     * @throws \InvalidArgumentException
     * @return MockBuilder
     */
    public function disableConstructor()
    {
        if ($this->isInterface()) {
            $message = "You cannot disable the constructor of an interface ({$this->className}).";
            throw new InvalidArgumentException($message);
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
     * @param string $property
     * @throws \InvalidArgumentException
     * @return MockBuilder
     */
    public function andReturnProperty($property)
    {
        ArgumentChecker::check($property, 'string');

        if ($this->isInterface()) {
            $message = "You cannot return a property from an interface ({$this->className}).";
            throw new InvalidArgumentException($message);
        }

        return $this->setAction(new Action\ReturnPropertyAction($property));
    }
}
