<?php

namespace Concise\Module;

use Concise\Console\Command;
use Concise\Core\DidNotMatchException;
use Concise\Core\Syntax;
use Concise\Core\SyntaxRenderer;
use ReflectionClass;
use ReflectionMethod;

abstract class AbstractModule
{
    public $data = array();

    /**
     * @var Syntax
     */
    public $syntax;

    /**
     * @var SyntaxRenderer
     */
    protected $syntaxRenderer;

    abstract public function getName();

    /**
     * @param string $syntax
     * @param array  $data
     * @return string
     */
    public function renderFailureMessage($syntax, array $data = array())
    {
        return $this->getSyntaxRenderer()->render($syntax, $data);
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param SyntaxRenderer $syntaxRenderer
     */
    public function setSyntaxRenderer(SyntaxRenderer $syntaxRenderer)
    {
        $this->syntaxRenderer = $syntaxRenderer;
    }

    /**
     * @return SyntaxRenderer
     */
    public function getSyntaxRenderer()
    {
        if (!$this->syntaxRenderer) {
            $this->syntaxRenderer = new SyntaxRenderer(
                Command::getInstance()->getColorScheme()
            );
        }

        return $this->syntaxRenderer;
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

    protected function fail()
    {
        throw new DidNotMatchException();
    }

    protected function failIf($test)
    {
        if ($test) {
            $this->fail();
        } // @codeCoverageIgnore
    }
}
