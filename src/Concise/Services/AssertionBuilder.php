<?php

namespace Concise\Services;

use Concise\Syntax\MatcherParser;
use Concise\Assertion;
use Exception;

class AssertionBuilder
{
    /**
	 * @var array
	 */
    protected $args;

    /**
	 * @param array $args
	 */
    public function __construct(array $args)
    {
        $this->args = $args;
    }

    protected function getArgName($i)
    {
        return "arg" . ($i / 2);
    }

    protected function getData()
    {
        $data = array();
        $argc = count($this->args);
        for ($i = 0; $i < $argc; $i += 2) {
            $data[$this->getArgName($i)] = $this->args[$i];
        }

        return $data;
    }

    protected function getSyntaxString()
    {
        $syntax = array();
        $argc = count($this->args);
        for ($i = 0; $i < $argc; $i += 2) {
            $syntax[] = $this->getArgName($i);
            if ($i < $argc - 1) {
                $syntax[] = $this->args[$i + 1];
            }
        }

        return implode(' ', $syntax);
    }

    protected function getAlternateSyntaxString()
    {
        $syntax = array($this->args[0]);
        $argc = count($this->args);
        for ($i = 1; $i < $argc; $i += 2) {
            $syntax[] = $this->getArgName($i - 1);
            if ($i < $argc - 1) {
                $syntax[] = $this->args[$i + 1];
            }
        }

        return implode(' ', $syntax);
    }

    /**
	 * @return Assertion
	 */
    public function getAssertion()
    {
        $matcherParser = MatcherParser::getInstance();
        if (count($this->args) === 1 && is_bool($this->args[0])) {
            return $matcherParser->compile($this->args[0] ? 'true' : 'false');
        }

        $syntaxString = $this->getSyntaxString();
        $data = $this->getData();

        try {
            return $matcherParser->compile($syntaxString, $data);
        } catch (Exception $e) {
            $syntaxString = $this->getAlternateSyntaxString();

            return $matcherParser->compile($syntaxString, $data);
        }
    }
}
