<?php

namespace Concise\Mock;

use Concise\Core\ArgumentChecker;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class ClassCompiler
{
    /**
     * The fully qualified class name.
     *
     * @var string
     */
    protected $className;

    /**
     * A unique string to be appended to the mock class name to make it unique
     * (separate it from other mocks with the same name)
     *
     * @var string
     */
    protected $mockUnique;

    /**
     * The rules for the methods.
     *
     * @var array
     */
    protected $rules = array();

    /**
     * @var bool
     */
    protected $niceMock;

    /**
     * Arguments to pass to the constructor for the mock.
     *
     * @var array
     */
    protected $constructorArgs;

    /**
     * @var boolean
     */
    protected $disableConstructor;

    /**
     * You may specify a custom class name for the mock.
     *
     * @var string
     */
    protected $customClassName;

    /**
     * @var string[]
     */
    protected $expose = array();

    /**
     * @var array
     */
    protected $methods = array();

    /*
	 * @param string  $className
	 * @param boolean $niceMock
	 * @param array   $constructorArgs
     * @param boolean $disableConstructor
	 */
    public function __construct(
        $className,
        $niceMock = false,
        array $constructorArgs = array(),
        $disableConstructor = false,
        $disableClone = false
    ) {
        ArgumentChecker::check($className, 'string');
        ArgumentChecker::check($niceMock, 'bool', 2);
        ArgumentChecker::check($disableConstructor, 'boolean', 4);

        if (!class_exists($className) && !interface_exists($className)) {
            $message =
                "The class '$className' is not loaded so it cannot be mocked.";
            throw new InvalidArgumentException($message);
        }
        if (interface_exists($className) && $niceMock) {
            $message =
                "You cannot create a nice mock of an interface ($className).";
            throw new InvalidArgumentException($message);
        }
        $this->className = ltrim($className, '\\');
        $this->mockUnique = '_' . substr(md5(rand()), 24);
        $this->niceMock = $niceMock;
        $this->constructorArgs = $constructorArgs;
        $this->disableConstructor = $disableConstructor;
        $this->disableClone = $disableClone;
    }

    /**
     * Get the namespace for the mocked class.
     *
     * @param  string $className
     * @return string
     */
    protected function getNamespaceName($className = null)
    {
        $parts = explode('\\', $className ?: $this->className);
        array_pop($parts);

        return implode('\\', $parts);
    }

    /**
     * Get the class name (not including the namespace) of the class to be
     * mocked.
     *
     * @param  string $className
     * @return string
     */
    protected function getClassName($className = null)
    {
        $parts = explode('\\', $className ?: $this->className);

        return $parts[count($parts) - 1];
    }

    protected function methodIsAllowedToBeMocked($method)
    {
        try {
            $realMethod = new ReflectionMethod($this->className, $method);
            $this->finalMethodsCanNotBeMocked($realMethod);
            $this->privateMethodsCanNotBeMocked($realMethod);
        } catch (ReflectionException $e) {
            if (!method_exists($this->className, '__call')) {
                return false;
            }
        }

        return true;
    }

    protected function getPrototype($method)
    {
        $this->methodMustBeMockable($method);
        $prototypeBuilder = new PrototypeBuilder();
        $prototypeBuilder->hideAbstract = true;
        try {
            $realMethod = new ReflectionMethod($this->className, $method);

            return $prototypeBuilder->getPrototype($realMethod);
        } catch (ReflectionException $e) {
            return $prototypeBuilder->getPrototypeForNonExistentMethod($method);
        }
    }

    protected function getPublicPrototype($method)
    {
        $prototype = $this->getPrototype($method);
        if (array_key_exists($method, $this->expose)) {
            $prototype = str_replace('protected ', 'public ', $prototype);
        }

        return $prototype;
    }

    protected function makeMethodThrowException(\ReflectionMethod $method)
    {
        $prototype = $this->getPublicPrototype($method->getName());
        $message = "{$method->getName(
        )}() does not have an associated action - consider a niceMock()?";
        if ($method->isAbstract()) {
            $message = "{$method->getName(
            )}() is abstract and has no associated action.";
        }
        $this->methods[$method->getName()] = <<<EOF
$prototype {
	throw new \\Exception("$message");
}
EOF;
    }

    protected function makeAllMethodsThrowException(\ReflectionClass $refClass)
    {
        $this->methods = array();
        foreach ($refClass->getMethods() as $method) {
            if (!$method->isPrivate() && !$method->isFinal()) {
                $this->makeMethodThrowException($method);
            }
        }
    }

    protected function finalMethodsCanNotBeMocked(\ReflectionMethod $method)
    {
        if ($method->isFinal()) {
            throw new InvalidArgumentException(
                "Method {$this->className}::{$method->getName()}() is final so it cannot be mocked."
            );
        }
    }

    protected function privateMethodsCanNotBeMocked(\ReflectionMethod $method)
    {
        if ($method->isPrivate()) {
            throw new InvalidArgumentException(
                "Method {$this->className}::{$method->getName()}() cannot be mocked because it it private."
            );
        }
    }

    protected function renderRule($method, array $withs)
    {
        $this->methodMustBeMockable($method);
        $actionCode = '';
        $defaultActionCode = '';

        foreach ($withs as $rule) {
            /** @var $action \Concise\Mock\Action\AbstractAction */
            $action = $rule['action'];
            if (null === $rule['with']) {
                $defaultActionCode = $action->getActionCode();
            } else {
                $args = addslashes(json_encode($rule['with']));
                $args =
                    str_replace(array('$', "\\'"), array('\\$', "'"), $args);
                $actionCode .= <<<EOF
    \$matcher = new \Concise\Mock\ArgumentMatcher();
    \$methodArguments = new \Concise\Mock\MethodArguments();
    \$a = \$methodArguments->getMethodArgumentValues(func_get_args(), "{$this->getNamespaceName(
                )}\\{$this->getClassName()}::$method");
    if (\$matcher->match(json_decode("$args"), \$a)) {
        {$action->getActionCode()}
    }
EOF;
            }
        }

        $prototype = $this->getPublicPrototype($method);
        $this->methods[$method] = <<<EOF
$prototype {
	if (!array_key_exists('$method', self::\$_methodCalls)) {
		self::\$_methodCalls['$method'] = array();
	}
    \$methodArguments = new \Concise\Mock\MethodArguments();
    \$a = \$methodArguments->getMethodArgumentValues(func_get_args(), "{$this->getNamespaceName(
        )}\\{$this->getClassName()}::$method");
	self::\$_methodCalls['$method'][] = \$a;
	$actionCode
	$defaultActionCode
}
EOF;
    }

    protected function renderRules()
    {
        foreach ($this->rules as $method => $withs) {
            $this->renderRule($method, $withs);
        }
    }

    protected function renderConstructor()
    {
        if ($this->disableConstructor) {
            $this->methods['__construct'] = 'public function __construct() {}';
        } else {
            unset($this->methods['__construct']);
        }
    }

    protected function renderClone()
    {
        if ($this->disableClone) {
            $this->methods['__clone'] = 'public function __clone() {}';
        } else {
            unset($this->methods['__clone']);
        }
    }

    protected function exposeMethods()
    {
        foreach ($this->expose as $method => $value) {
            if (!array_key_exists($method, $this->methods)) {
                $prototype = $this->getPublicPrototype($method);
                $this->methods[$method] =
                    "$prototype { return call_user_func_array(\"parent::{$method}\", func_get_args()); }";
            }
        }
    }

    protected function finalClassesCanNotBeMocked(\ReflectionClass $refClass)
    {
        if ($refClass->isFinal()) {
            throw new InvalidArgumentException(
                "Class {$this->className} is final so it cannot be mocked."
            );
        }
    }

    protected function setUpGetCallsForMethod()
    {
        $this->methods['getCallsForMethod'] = <<<EOF
public function getCallsForMethod(\$method)
{
	return array_key_exists(\$method, self::\$_methodCalls) ? self::\$_methodCalls[\$method] : array();
}
EOF;
    }

    protected function getNamespaceCode()
    {
        if ($this->getMockNamespaceName()) {
            return "namespace " . $this->getMockNamespaceName() . "; ";
        }

        return '';
    }

    protected function getSuperWord(\ReflectionClass $refClass)
    {
        if ($refClass->isInterface()) {
            return 'implements';
        }

        return 'extends';
    }

    public function makeAllAbstractMethodsThrowException(
        ReflectionClass $refClass
    ) {
        foreach ($refClass->getMethods() as $method) {
            if ($method->isAbstract()) {
                $this->makeMethodThrowException($method);
            }
        }
    }

    /**
     * Generate the PHP code for the mocked class.
     *
     * @return string
     */
    public function generateCode()
    {
        $refClass = new ReflectionClass($this->className);
        $this->finalClassesCanNotBeMocked($refClass);

        $this->methods = array();
        $this->makeAllAbstractMethodsThrowException($refClass);
        if (!$this->niceMock || $refClass->isInterface()) {
            $this->makeAllMethodsThrowException($refClass);
        }
        $this->renderRules();
        $this->renderConstructor();
        $this->renderClone();
        $this->exposeMethods();
        $this->setUpGetCallsForMethod();

        $code = $this->getNamespaceCode();
        $methods = implode("\n", $this->methods);
        $superWord = $this->getSuperWord($refClass);

        $class = "class {$this->getMockName()} $superWord \\{$this->className}";
        if ('implements' === $superWord) {
            $class .= ', ';
        } else {
            $class .= ' implements ';
        }
        $class .= '\Concise\Mock\MockInterface';

        return $code .
        "$class { public static \$_methodCalls = array(); $methods }";
    }

    /**
     * Get the name of the mocked class (not including the namespace).
     *
     * @return string
     */
    protected function getMockName()
    {
        if ($this->customClassName) {
            return $this->getClassName($this->customClassName);
        }

        return $this->getClassName() . $this->mockUnique;
    }

    /**
     * @return string
     */
    protected function getMockNamespaceName()
    {
        return $this->getNamespaceName($this->customClassName);
    }

    /**
     * Create a new instance of the mocked class. There is no need to generate
     * the code before invoking this.
     *
     * @return object
     */
    public function newInstance()
    {
        /** @noinspection PhpUnusedLocalVariableInspection */
        $name = "{$this->getMockNamespaceName()}\\{$this->getMockName()}";
        /** @noinspection PhpUnusedLocalVariableInspection */
        $code = $this->generateCode();
        /** @var $reflect \ReflectionClass */
        $reflect = eval("$code return new \\ReflectionClass('$name');");

        try {
            return $reflect->newInstanceArgs($this->constructorArgs);
        } catch (ReflectionException $e) {
            return $reflect->newInstance();
        }
    }

    /**
     * Set all the rules for the mock.
     *
     * @param array $rules
     */
    public function setRules(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * @param string $className
     * @throws \InvalidArgumentException
     */
    public function setCustomClassName($className)
    {
        ArgumentChecker::check($className, 'string');

        if (strpos($className, '\\') === false) {
            $className = $this->getNamespaceName() . '\\' . $className;
        }
        if (substr($className, 0, 1) === '\\') {
            $className = substr($className, 1);
        }
        if (!preg_match(
            "/^(\\\\?[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)+$/",
            $className
        )
        ) {
            throw new InvalidArgumentException(
                "Invalid class name '$className'."
            );
        }
        if (class_exists($className, false)) {
            throw new InvalidArgumentException(
                "You cannot use '$className' because a class with that name already exists."
            );
        }
        $this->customClassName = $className;
    }

    protected function methodMustBeMockable($method)
    {
        if (!$this->methodIsAllowedToBeMocked($method)) {
            throw new InvalidArgumentException(
                "Method {$this->className}::$method() does not exist."
            );
        }
    }

    /**
     * @param string $method
     */
    public function addExpose($method)
    {
        ArgumentChecker::check($method, 'string');

        $this->methodMustBeMockable($method);
        $this->expose[$method] = true;
    }
}
