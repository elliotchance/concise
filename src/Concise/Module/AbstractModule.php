<?php

namespace Concise\Module;

use Concise\Matcher\Syntax;
use Concise\Services\SyntaxRenderer;
use ReflectionClass;
use ReflectionMethod;

abstract class AbstractModule
{
    public $data = array();

    abstract public function getName();

    /**
     * @param string $syntax
     * @param array  $data
     * @return string
     */
    public function renderFailureMessage($syntax, array $data = array())
    {
        $renderer = new SyntaxRenderer();

        return $renderer->render($syntax, $data);
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    protected function getSyntaxesFromMethod(ReflectionMethod $method)
    {
        $doc = $method->getDocComment();
        $m = $method->getName();
        $isNested = strpos($doc, '@nested') !== false;
        $syntaxes = array();
        $description = '';

        foreach (explode("\n", $doc) as $line) {
            if (preg_match('/@[a-zA-Z]+/', $line)) {
                continue;
            }
            $description .= ltrim($line, ' */') . "\n";
        }

        foreach (explode("\n", $doc) as $line) {
            $pos = strpos($line, '@syntax');

            // Ignore lines that are not a syntax.
            if ($pos === false) {
                continue;
            }

            $syntax = new Syntax(
                trim(substr($line, $pos + 7)),
                $method->getDeclaringClass()->getName() .
                '::' .
                $m,
                $isNested
            );
            $syntax->setDescription($description);
            $syntaxes[] = $syntax;
        }

        return $syntaxes;
    }

    /**
     * @return Syntax[]
     */
    public function getSyntaxes()
    {
        $reflectionClass = new ReflectionClass($this);
        $methods = array();
        foreach ($reflectionClass->getMethods() as $method) {
            $methods = array_merge(
                $methods,
                $this->getSyntaxesFromMethod($method)
            );
        }

        return $methods;
    }
}
