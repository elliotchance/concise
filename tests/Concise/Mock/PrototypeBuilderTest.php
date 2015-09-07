<?php

namespace Concise\Mock;

use Concise\TestCase;

// `callable` does not exist in PHP 5.3 and we need it for the prototype below.
if (version_compare(phpversion(), '5.4', '<')) {
    eval("class callable {}");
}

abstract class MyClass
{
    public function foo()
    {
    }

    abstract protected function bar();

    abstract protected function baz($a, $b);

    abstract protected function a(\DateTime $a);

    abstract protected function b($a = 123);

    abstract protected function c(&$a);

    abstract protected function d(array $a);

    abstract protected function e(\Closure $a);

    abstract protected function f($a = array());

    abstract protected function g(callable $a);

}

class PrototypeBuilderTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->builder = new PrototypeBuilder();
    }

    public function testPrototypeIsBuiltFromReflectionMethod()
    {
        $method = new \ReflectionMethod('\Concise\Mock\MyClass', 'foo');
        $this->aassert($this->builder->getPrototype($method))
            ->equals('public function foo()');
    }

    public function testWillRespectPrototypeModifiers()
    {
        $method = new \ReflectionMethod('\Concise\Mock\MyClass', 'bar');
        $this->aassert($this->builder->getPrototype($method))
            ->equals('abstract protected function bar()');
    }

    public function testWillRespectPrototypeArguments()
    {
        $method = new \ReflectionMethod('\Concise\Mock\MyClass', 'baz');
        $this->aassert($this->builder->getPrototype($method))
            ->equals('abstract protected function baz($a, $b)');
    }

    public function testWillNotReturnAbstractKeywordIfToldNotTo()
    {
        $method = new \ReflectionMethod('\Concise\Mock\MyClass', 'bar');
        $this->builder->hideAbstract = true;
        $this->aassert($this->builder->getPrototype($method))
            ->equals('protected function bar()');
    }

    public function testWillRespectPrototypeArgumentTypeHinting()
    {
        $method = new \ReflectionMethod('\Concise\Mock\MyClass', 'a');
        $this->aassert($this->builder->getPrototype($method))
            ->equals('abstract protected function a(\DateTime $a)');
    }

    public function testWillRespectPrototypeArgumentDefaultValue()
    {
        $method = new \ReflectionMethod('\Concise\Mock\MyClass', 'b');
        $this->aassert($this->builder->getPrototype($method))
            ->equals('abstract protected function b($a = 123)');
    }

    public function testWillRespectPrototypeArgumentPassByReference()
    {
        $method = new \ReflectionMethod('\Concise\Mock\MyClass', 'c');
        $this->aassert($this->builder->getPrototype($method))
            ->equals('abstract protected function c(&$a)');
    }

    public function testWillNotSetADefaultValueForInternalMethods()
    {
        $method = new \ReflectionMethod('\DateTime', 'setTime');
        $this->aassert($this->builder->getPrototype($method))
            ->equals('public function setTime($hour, $minute, $second = NULL)');
    }

    public function testArrayHint()
    {
        $method = new \ReflectionMethod('\Concise\Mock\MyClass', 'd');
        $this->aassert($this->builder->getPrototype($method))
            ->equals('abstract protected function d(array $a)');
    }

    public function testClosureHint()
    {
        $method = new \ReflectionMethod('\Concise\Mock\MyClass', 'e');
        $this->aassert($this->builder->getPrototype($method))
            ->equals('abstract protected function e(\Closure $a)');
    }

    public function testArrayDefaultValue()
    {
        $method = new \ReflectionMethod('\Concise\Mock\MyClass', 'f');
        $this->aassert($this->builder->getPrototype($method))
            ->equals("abstract protected function f(\$a = array (\n))");
    }

    public function testPrototypeCanBeBuiltWithOnlyAMethodName()
    {
        $this->aassert($this->builder->getPrototypeForNonExistentMethod('foo'))
            ->equals('public function foo()');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected string, but got integer for argument 1
     */
    public function testMethodMustBeAString()
    {
        $this->builder->getPrototypeForNonExistentMethod(123);
    }

    /**
     * @requires PHP 5.4
     */
    public function testCallableHint()
    {
        $method = new \ReflectionMethod('\Concise\Mock\MyClass', 'g');
        $this->aassert($this->builder->getPrototype($method))
            ->equals('abstract protected function g(callable $a)');
    }
}
