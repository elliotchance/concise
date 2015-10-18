<?php

namespace Concise\Core;

use Concise\Mock\MockBuilder;
use Concise\Mock\MockInterface;
use Concise\Mock\MockManager;
use Concise\Module\ArrayModule;
use Concise\Module\BasicModule;
use Concise\Module\BooleanModule;
use Concise\Module\DateAndTimeModule;
use Concise\Module\ExceptionModule;
use Concise\Module\FileModule;
use Concise\Module\NumberModule;
use Concise\Module\ObjectModule;
use Concise\Module\RegularExpressionModule;
use Concise\Module\StringModule;
use Concise\Module\TypeModule;
use Concise\Module\UrlModule;
use Exception;
use PHPUnit_Framework_AssertionFailedError;
use ReflectionClass;
use ReflectionException;


class TestCase extends BaseAssertions
{
    /**
     * Used as a placeholder for with() clauses where the parameter is
     * unrestrictive. For the curious, this is the SHA1('a') with an extra 'a'
     * on the end.
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
    public $verifyFailures = array();

    /**
     * @var null|\Concise\Core\AssertionBuilder
     */
    protected $currentAssertion = null;

    /**
     * @param string|null $name
     * @param array       $data
     * @param string      $dataName
     */
    public function __construct(
        $name = null,
        array $data = array(),
        $dataName = ''
    ) {
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
     * @return ModuleManager
     */
    protected function getModuleManagerInstance()
    {
        return ModuleManager::getInstance();
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
     *
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
     * @return void
     */
    public function tearDown()
    {
        AssertionBuilder::validateLastAssertion();
        $this->mockManager->validateMocks();
        if ($this->verifyFailures) {
            $count = count($this->verifyFailures);
            $message =
                "$count verify failure" . ($count === 1 ? '' : 's') . ":";
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
    public function mock(
        $className = '\stdClass',
        array $constructorArgs = array()
    ) {
        return new MockBuilder($this, $className, false, $constructorArgs);
    }

    /**
     * @param  string $className
     * @param  array  $constructorArgs
     * @return MockBuilder
     */
    public function niceMock(
        $className = '\stdClass',
        array $constructorArgs = array()
    ) {
        return new MockBuilder($this, $className, true, $constructorArgs);
    }

    /**
     * @param object $instance
     * @return MockBuilder
     */
    public function partialMock($instance)
    {
        ArgumentChecker::check($instance, 'object');
        $mockBuilder =
            new MockBuilder($this, get_class($instance), true, array());
        $mockBuilder->disableConstructor();
        $mockBuilder->setObjectState($instance);
        return $mockBuilder;
    }

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        $modules = array(
            new ArrayModule(),
            new BasicModule(),
            new BooleanModule(),
            new DateAndTimeModule(),
            new ExceptionModule(),
            new FileModule(),
            new NumberModule(),
            new ObjectModule(),
            new RegularExpressionModule(),
            new StringModule(),
            new TypeModule(),
            new UrlModule(),
        );
        foreach ($modules as $module) {
            ModuleManager::getInstance()
                ->loadModule($module);
        }
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

    protected function getReflectionProperty(
        $object,
        $property,
        $className = null
    ) {
        // If no class is provided we need to determine which class contains the
        // property.
        if (null === $className) {
            $className = get_class($object);
            $reflection = new ReflectionClass($className);
            while ($reflection) {
                try {
                    $reflection->getProperty($property);

                    // If an exception was not thrown then we have found the
                    // class that contains the property we are looking for so we
                    // can remeber the class anem and jump out here.
                    $className = $reflection->getName();
                    break;
                } catch (ReflectionException $e) {
                    $reflection = $reflection->getParentClass();
                }
            }
        }

        if ($object instanceof MockInterface) {
            $className = get_parent_class($object);
            if (!$className) {
                $message = "You cannot set a property on an interface (" .
                    get_class($object) . ").";
                throw new Exception($message);
            }
        }

        $reflection = new ReflectionClass($className);
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);

        return $property;
    }

    protected function shouldAccessProperty($object, $property)
    {
        return property_exists($object, $property) ||
        method_exists($object, '__get');
    }

    public function getProperty($object, $property, $class = null)
    {
        try {
            $property = $this->getReflectionProperty(
                $object,
                $property,
                $class
            );
            return $property->getValue($object);
        } catch (ReflectionException $e) {
            if ($this->shouldAccessProperty($object, $property)) {
                return $object->$property;
            }

            throw $e;
        }
    }

    public function setProperty($object, $name, $value, $class = null)
    {
        try {
            $property = $this->getReflectionProperty($object, $name, $class);
            $property->setValue($object, $value);
        } catch (ReflectionException $e) {
            $object->$name = $value;
        }
    }

    /**
     * Validate a mock now.
     *
     * @param  MockInterface $mock The mock instance to verify.
     * @return bool
     */
    public function assertMock(MockInterface $mock)
    {
        $this->mockManager->validateMockByInstance($mock);
        return true;
    }

    public function __call($name, $args)
    {
        $verify = $name[0] === 'v';
        $name = lcfirst(substr($name, 6));
        if ($name === '') {
            $name = '_';
        }

        if (count($args) > 1) {
            $builder = new AssertionBuilder($this, $args[0], $verify);
            /** @noinspection PhpUndefinedMethodInspection */
            return $builder->$name($args[1]);
        }

        $builder = new AssertionBuilder($this, null, $verify);
        /** @noinspection PhpUndefinedMethodInspection */
        return $builder->$name($args[0]);
    }
}
