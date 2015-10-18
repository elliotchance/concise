<?php

namespace Concise\Core;

use Concise\Module\AbstractModule;
use Exception;
use PHPUnit_Framework_AssertionFailedError;

class AssertionBuilder
{
    protected $data = array();

    protected $syntax = '';

    /**
     * @var TestCase
     */
    protected $testCase;

    protected $failureMessage;

    /**
     * @var bool
     */
    protected $verify;

    /**
     * @var null|AssertionBuilder
     */
    public static $lastBuilder = null;

    public function __construct(
        TestCase $testCase,
        $failureMessage = null,
        $verify = false
    ) {
        self::validateLastAssertion();
        self::$lastBuilder = $this;
        $this->testCase = $testCase;
        $this->failureMessage = $failureMessage;
        $this->verify = $verify;
    }

    public function __call($words, $args)
    {
        if (null !== $words) {
            $this->syntax .=
                strtolower(preg_replace('/([A-Z])/', ' $1', $words)) .
                ' ';
        }

        if (count($args) > 0) {
            $this->data[] = $args[0];
            $this->syntax .= '? ';
        }

        try {
            $syntax = ModuleManager::getInstance()->getSyntaxCache()
                ->getSyntax($this->getSyntax());
        } catch (Exception $e) {
            $syntax = null;
        }
        if ($syntax) {
            self::$lastBuilder = null;

            $class = $syntax->getClass();
            /** @var AbstractModule $instance */
            $instance = new $class();
            $data = $this->getData();
            $types = $syntax->getArgumentTypes();
            $checker = new DataTypeChecker();
            for ($i = 0; $i < count($types); ++$i) {
                try {
                    $data[$i] = $checker->check($types[$i], $data[$i]);
                } catch (DataTypeMismatchException $e) {
                    $renderer = new ValueRenderer();
                    throw new Exception(
                        "Argument " .
                        ($i + 1) .
                        ' (' .
                        $renderer->render($data[$i]) .
                        ') must be ' .
                        implode(' or ', $types[$i]) .
                        '.'
                    );
                }
            }
            $instance->setData($data);
            $instance->syntax = $syntax;

            try {
                $instance->{$syntax->getMethod()}();
                $this->testCase->assertTrue(true);
            } catch (DidNotMatchException $e) {
                $this->handleFailure($e);
            }
        }

        return $this;
    }

    public function __get($name)
    {
        return $this->__call($name, array());
    }

    public function getData()
    {
        return $this->data;
    }

    public function getSyntax()
    {
        return rtrim($this->syntax);
    }

    public function _($value)
    {
        return $this->__call(null, array($value));
    }

    /**
     * @param Exception $e
     * @throws DidNotMatchException
     * @throws Exception
     */
    public function handleFailure(Exception $e)
    {
        if ($this->verify) {
            $this->testCase->verifyFailures[] = $e->getMessage();
        } else {
            if ($this->failureMessage) {
                throw new PHPUnit_Framework_AssertionFailedError(
                    $this->failureMessage
                );
            }
            throw $e;
        }
    }

    public static function validateLastAssertion()
    {
        if (self::$lastBuilder) {
            $last = self::$lastBuilder;
            self::$lastBuilder = null;
            $last->handleFailure(
                new Exception('No such syntax "' . $last->getSyntax() . '"')
            );
        } // @codeCoverageIgnore
    }
}
