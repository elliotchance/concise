<?php

namespace Concise\Core;

use Concise\Module\AbstractModule;
use Concise\Validation\ArgumentChecker;
use Exception;
use ReflectionClass;

class ModuleManager
{
    /**
     * @var ModuleManager
     */
    protected static $instance = null;

    /**
     * @var array
     */
    protected $keywords = array();

    /**
     * @var SyntaxCache
     */
    protected $syntaxCache;

    /**
     * @var AbstractModule[]
     */
    protected $modules = array();

    public function __construct()
    {
        $this->syntaxCache = new SyntaxCache();
    }

    /**
     * @return AbstractModule[]
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * @return SyntaxCache
     */
    public function getSyntaxCache()
    {
        return $this->syntaxCache;
    }

    /**
     * @param  string $syntax
     * @return string
     */
    protected function getRawSyntax($syntax)
    {
        return preg_replace('/\\?:[^\s$]+/i', '?', $syntax);
    }

    /**
     * @param string $string
     * @param string $substring
     * @return bool
     */
    protected function endsWith($string, $substring)
    {
        return (substr($string, strlen($string) - strlen($substring)) ===
            $substring);
    }

    /**
     * @param string $syntax
     * @param array  $data
     * @throws NoMatcherFoundException
     * @return array
     */
    public function getMatcherForSyntax($syntax, array $data = array())
    {
        ArgumentChecker::check($syntax, 'string');

        $rawSyntax = $this->getRawSyntax($syntax);
        $endsWith = ' on error ?';
        if ($this->endsWith($rawSyntax, $endsWith)) {
            $rawSyntax =
                substr($rawSyntax, 0, strlen($rawSyntax) - strlen($endsWith));
        }

        foreach ($this->modules as $module) {
            $reflectionClass = new ReflectionClass($module);
            foreach($reflectionClass->getMethods() as $method) {
                $doc = $method->getDocComment();
                foreach (explode("\n", $doc) as $line) {
                    $pos = strpos($line, '@syntax');
                    if ($pos !== false) {
                        $s = new Syntax(trim(substr($line, $pos + 7)), $method->getDeclaringClass()->getName() . '::' . $method->getName());
                        if ($s->getRawSyntax() == $rawSyntax) {
                            $class = $s->getClass();
                            $r = array(
                                'matcher' => new $class(),
                                'originalSyntax' => $s->getSyntax(),
                            );
                            if ($this->endsWith(
                                $this->getRawSyntax($syntax),
                                $endsWith
                            )
                            ) {
                                $r['on_error'] = $data[count($data) - 1];
                            }
                            return $r;
                        }
                    }
                }
            }
        }

        throw new NoMatcherFoundException(array($syntax));
    }

    /**
     * @return ModuleManager
     */
    public static function getInstance()
    {
        // @codeCoverageIgnoreStart
        if (null === self::$instance) {
            // For some reason this line never get covered. Clearly it does run
            // otherwise concise would blow up. But to be extra sure there is a
            // specific unit test:
            //   ModuleManagerTest::testGetInstanceIsASingleton()

            self::$instance = new ModuleManager();
        }
        // @codeCoverageIgnoreEnd

        return self::$instance;
    }

    /**
     * @testDox Here is another case of the line not being covered. Without this
     *     method executing correctly no assertions would work.
     * @codeCoverageIgnore
     * @param AbstractModule $module
     * @throws Exception
     */
    public function loadModule(AbstractModule $module)
    {
        $key = get_class($module);
        if (!array_key_exists($key, $this->modules)) {
            $this->modules[$key] = $module;

            foreach ($module->getSyntaxes() as $syntax) {
                $this->syntaxCache->add($syntax);
            }
        }
    }

    protected function getWordsForSyntaxes(array $syntaxes)
    {
        $r = array();
        foreach (array_keys($syntaxes) as $syntax) {
            foreach (explode(' ', $syntax) as $word) {
                if ($word[0] !== '?') {
                    $r[] = $word;
                }
            }
        }

        return $r;
    }

    /**
     * @return array
     */
    protected function getRawKeywords()
    {
        $r = array('error', 'on');
        foreach ($this->modules as $module) {
            $reflectionClass = new ReflectionClass($module);
            foreach($reflectionClass->getMethods() as $method) {
                $doc = $method->getDocComment();
                foreach (explode("\n", $doc) as $line) {
                    $pos = strpos($line, '@syntax');
                    if ($pos !== false) {
                        $syntax = new Syntax(trim(substr($line, $pos + 7)), $method->getDeclaringClass()->getName() . '::' . $method->getName());
                        $r = array_merge(
                            $r,
                            $this->getWordsForSyntaxes(
                                array($syntax->getSyntax() => '')
                            )
                        );
                    }
                }
            }
        }

        $r = array_unique($r);
        sort($r);

        return $r;
    }

    /**
     * @return array
     */
    public function getKeywords()
    {
        if (0 === count($this->keywords)) {
            $this->keywords = $this->getRawKeywords();
        }

        return $this->keywords;
    }
}
