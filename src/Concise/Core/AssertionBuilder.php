<?php

namespace Concise\Core;

use Concise\Module\AbstractModule;
use Concise\Services\ValueRenderer;
use Concise\TestCase;
use Concise\Validation\DataTypeChecker;
use Concise\Validation\DataTypeMismatchException;
use Exception;

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

    public function __construct(
        TestCase $testCase,
        $failureMessage = null,
        $verify = false
    ) {
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
            $syntax = ModuleManager::getInstance()->getSyntaxCache()->getSyntax(
                $this->getSyntax()
            );
        } catch (Exception $e) {
            $syntax = null;
        }
        if ($syntax) {
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
                if ($this->verify) {
                    $this->testCase->verifyFailures[] = $e->getMessage();
                } else {
                    if ($this->failureMessage) {
                        throw new DidNotMatchException($this->failureMessage);
                    }
                    throw $e;
                }
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
}
