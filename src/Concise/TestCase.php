<?php

namespace Concise;

use Concise\Mock\MockBuilder;
use Concise\Services\AssertionBuilder;
use Concise\Syntax\MatcherParser;
use Concise\Mock\MockManager;
use Concise\Validation\ArgumentChecker;
use Exception;
use PHPUnit_Framework_AssertionFailedError;
use PHPUnit_Framework_TestCase;
use ReflectionClass;
use Concise\Mock\MockInterface;
use ReflectionException;

// Load the keyword cache before the test suite begins.
Keywords::load();

class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * Used as a placeholder for with() clauses where the parameter is unrestrictive. For the
     * curious, this is the SHA1('a') with an extra 'a' on the end.
     */
    const ANYTHING = '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8a';

    /**
	 * @var MockManager
	 */
    protected $mockManager;

    /**
     * @var array
     */
    protected $properties = array();

    /**
     * @var array
     */
    protected $verifyFailures = array();

    /**
     * @param string|null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->mockManager = new MockManager($this);
    }

    /**
     * @return MockManager
     */
    public function getMockManager()
    {
        return $this->mockManager;
    }

    /**
	 * @return MatcherParser
	 */
    protected function getMatcherParserInstance()
    {
        return MatcherParser::getInstance();
    }

    /**
     * @param  string $name
     * @throws Exception
     * @return mixed
     */
    public function __get($name)
    {
        if (!array_key_exists($name, $this->properties)) {
            throw new Exception("No such attribute '{$name}'.");
        }

        return $this->properties[$name];
    }

    public function __isset($name)
    {
        return array_key_exists($name, $this->properties);
    }

    public function __unset($name)
    {
        unset($this->properties[$name]);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @throws Exception
     */
    public function __set($name, $value)
    {
        $parser = $this->getMatcherParserInstance();
        if (in_array($name, $parser->getKeywords())) {
            throw new Exception("You cannot assign an attribute with the keyword '$name'.");
        }
        $this->properties[$name] = $value;
    }

    /**
	 * @return array
	 */
    public function getData()
    {
        return $this->properties + get_object_vars($this);
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

    protected function createAssertion(array $args)
    {
        if (count($args) > 1 || is_bool($args[0])) {
            $builder = new AssertionBuilder($args);
            return $builder->getAssertion();
        }

        return $this->getMatcherParserInstance()->compile($args[0], $this->getData());
    }

    /**
     * @return boolean
	 */
    public function assert()
    {
        $assertion = $this->createAssertion(func_get_args());
        if ($this instanceof TestCase) {
            $assertion->setTestCase($this);
        }
        return $assertion->run();
    }

    /**
     * @return void
     */
    public function tearDown()
    {
        $this->mockManager->validateMocks();
        if ($this->verifyFailures) {
            $count = count($this->verifyFailures);
            $message = "$count verify failure" . ($count === 1 ? '' : 's') . ":";
            $message .= "\n\n" . implode("\n\n", $this->verifyFailures);
            throw new PHPUnit_Framework_AssertionFailedError($message);
        }
        parent::tearDown();
    }

    /**
	 * @param  string $className
	 * @param  array  $constructorArgs
	 * @return MockBuilder
	 */
    public function mock($className = '\stdClass', array $constructorArgs = array())
    {
        return new MockBuilder($this, $className, false, $constructorArgs);
    }

    /**
	 * @param  string $className
	 * @param  array  $constructorArgs
	 * @return MockBuilder
	 */
    public function niceMock($className = '\stdClass', array $constructorArgs = array())
    {
        return new MockBuilder($this, $className, true, $constructorArgs);
    }

    /**
     * @param object $instance
     * @return MockBuilder
     */
    public function partialMock($instance)
    {
        ArgumentChecker::check($instance, 'object');
        $mockBuilder = new MockBuilder($this, get_class($instance), true, array());
        $mockBuilder->disableConstructor();
        $mockBuilder->setObjectState($instance);
        return $mockBuilder;
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
        $this->verifyFailures = array();
    }

    /**
     * @param MockBuilder $mockBuilder
     * @param object      $mockInstance
     */
    public function addMockInstance(MockBuilder $mockBuilder, $mockInstance)
    {
        $this->mockManager->addMockInstance($mockBuilder, $mockInstance);
    }

    protected function getReflectionProperty($object, $property)
    {
        $className = get_class($object);
        if ($object instanceof MockInterface) {
            $className = get_parent_class($object);
            if (!$className) {
                $message = "You cannot set a property on an interface (" . get_class($object) . ").";
                throw new Exception($message);
            }
        }
        $reflection = new ReflectionClass($className);
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);

        return $property;
    }

    public function getProperty($object, $property)
    {
        try {
            $property = $this->getReflectionProperty($object, $property);
            return $property->getValue($object);
        } catch (ReflectionException $e) {
            if (isset($object->$property)) {
                return $object->$property;
            }

            throw $e;
        }
    }

    public function setProperty($object, $name, $value)
    {
        try {
            $property = $this->getReflectionProperty($object, $name);
            $property->setValue($object, $value);
        } catch (ReflectionException $e) {
            $object->$name = $value;
        }
    }

    /**
     * Validate a mock now.
     * @param  MockInterface $mock The mock instance to verify.
     * @return bool
     */
    public function assertMock(MockInterface $mock)
    {
        $this->mockManager->validateMockByInstance($mock);
        return true;
    }

    /**
     * @return boolean|null
     */
    public function verify()
    {
        try {
            call_user_func_array(array($this, 'assert'), func_get_args());
        } catch (PHPUnit_Framework_AssertionFailedError $e) {
            $this->verifyFailures[] = $e->getMessage();
        }
    }
}
