<?php

namespace Concise;

use Concise\Mock\MockBuilder;
use Concise\Services\AssertionBuilder;
use Concise\Syntax\MatcherParser;
use Concise\Mock\MockManager;
use ReflectionClass;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Used as a placeholder for with() clauses where the parameter is unrestrictive. For the curious, this is the
     * SHA1('a') with an extra 'a' on the end.
     */
    const ANYTHING = '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8a';

    /**
	 * @var Concise\Mock\MockManager
	 */
    protected $mockManager;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->mockManager = new MockManager($this);
    }

    public function getMockManager()
    {
        return $this->mockManager;
    }

    /**
	 * @return \Concise\Syntax\MatcherParser
	 */
    protected function getMatcherParserInstance()
    {
        return MatcherParser::getInstance();
    }

    /**
	 * @param  string $name
	 * @return mixed
	 */
    public function __get($name)
    {
        if (!isset($this->$name)) {
            throw new \Exception("No such attribute '{$name}'.");
        }

        return $this->$name;
    }

    /**
	 * @param string $name
	 * @param mixed $value
	 */
    public function __set($name, $value)
    {
        $parser = MatcherParser::getInstance();
        if (in_array($name, $parser->getKeywords())) {
            throw new \Exception("You cannot assign an attribute with the keyword '$name'.");
        }
        $this->$name = $value;
    }

    /**
	 * @return array
	 */
    public function getData()
    {
        return get_object_vars($this);
    }

    /**
	 * @return string
	 */
    protected function getRealTestName()
    {
        $name = substr($this->getName(), 20);
        $pos = strpos($name, ':');

        return substr($name, 0, $pos);
    }

    /**
	 * These attributes are provided by the base PHPUnit classes.
	 * @return array
	 */
    public static function getPHPUnitProperties()
    {
        return array(
            'backupGlobals' => null,
            'backupGlobalsBlacklist' => array(),
            'backupStaticAttributes' => null,
            'backupStaticAttributesBlacklist' => array(),
            'runTestInSeparateProcess' => null,
            'preserveGlobalState' => true,
        );
    }

    /**
	 * @param  string $assertionString
	 */
    public function assert($assertionString)
    {
        if (count(func_get_args()) > 1 || is_bool($assertionString)) {
            $builder = new AssertionBuilder(func_get_args());
            $assertion = $builder->getAssertion();
        } else {
            $assertion = $this->getMatcherParserInstance()->compile($assertionString, $this->getData());
        }
        if ($this instanceof TestCase) {
            $assertion->setTestCase($this);
        } else {
            // It is important that we use assert_that() becuase it will make sure the setUp() and tearDown() are
            // wrapped around the assertion.
            return assert_that($assertionString);
        }
        $assertion->run();
    }

    public function tearDown()
    {
        $this->mockManager->validateMocks();
        parent::tearDown();
    }

    /**
	 * @param  string $className
	 * @param  array  $constructorArgs
	 * @return MockBuilder
	 */
    protected function mock($className = '\stdClass', array $constructorArgs = array())
    {
        return new MockBuilder($this, $className, false, $constructorArgs);
    }

    /**
	 * @param  string $className
	 * @param  array  $constructorArgs
	 * @return MockBuilder
	 */
    protected function niceMock($className = '\stdClass', array $constructorArgs = array())
    {
        return new MockBuilder($this, $className, true, $constructorArgs);
    }

    protected function loadKeywords()
    {
        $parser = MatcherParser::getInstance();

        $all = array();
        foreach ($parser->getAllMatcherDescriptions() as $syntax => $description) {
            $simpleSyntax = preg_replace('/\\?(:[a-zA-Z0-9-,]+)/', '?', $syntax);
            foreach (explode('?', $simpleSyntax) as $part) {
                $p = trim($part);
                $all[str_replace(' ', '_', $p)] = $p;
            }
        }

        foreach ($all as $name => $value) {
            if (!defined($name)) {
                define($name, $value);
            }
        }
        define('on_error', 'on error');
    }

    public function setUp()
    {
        parent::setUp();

        if (!defined('__KEYWORDS_LOADED')) {
            $this->loadKeywords();
            define('__KEYWORDS_LOADED', 1);
        }
    }

    /**
     * @param MockBuilder $mockBuilder
     * @param object      $mockInstance
     */
    public function addMockInstance(MockBuilder $mockBuilder, $mockInstance)
    {
        $this->mockManager->addMockInstance($mockBuilder, $mockInstance);
    }

    public function getProperty($object, $property)
    {
        $reflection = new ReflectionClass($object);
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->getValue($object);
    }

    public function setProperty($object, $property, $value)
    {
        $reflection = new ReflectionClass($object);
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);

        $property->setValue($object, $value);
    }
}
