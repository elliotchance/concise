<?php

namespace Concise\Services;

use Concise\Syntax\MatcherParser;
use Concise\Assertion;
use Concise\Syntax\NoMatcherFoundException;
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

    /**
     * @param int $i
     * @return string
     */
    protected function getArgName($i)
    {
        return "arg" . ($i / 2);
    }

    protected function getData($offset = 0)
    {
        $data = array();
        $argc = count($this->args);
        for ($i = $offset; $i < $argc; $i += 2) {
            $data[$this->getArgName($i - $offset)] = $this->args[$i];
        }

        return $data;
    }

    protected function getAlternateData()
    {
        return $this->getData(1);
    }

    protected function getSyntaxString($syntax = array(), $offset = 0)
    {
        $argc = count($this->args);
        for ($i = $offset; $i < $argc; $i += 2) {
            $syntax[] = $this->getArgName($i - $offset);
            if ($i < $argc - 1) {
                $v = $this->args[$i + 1];
                $syntax[] = is_object($v) ? '<object>' : $v;
            }
        }

        return implode(' ', $syntax);
    }

    protected function getAlternateSyntaxString()
    {
        return $this->getSyntaxString(array($this->args[0]), 1);
    }

    protected function getSyntaxes()
    {
        $syntaxes = array(
            array(
                'syntax' => $this->getSyntaxString(),
                'data' => $this->getData(),
            ),
        );

        if (is_string($this->args[0])) {
            $syntaxes[] = array(
                'syntax' => $this->getAlternateSyntaxString(),
                'data' => $this->getAlternateData(),
            );
        }

        return $syntaxes;
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

        $syntaxes = array();
        foreach ($this->getSyntaxes() as $syntax) {
            try {
                return $matcherParser->compile($syntax['syntax'], $syntax['data']);
            } catch (NoMatcherFoundException $e) {
                // Syntax could not be compiled, try the next one.
                $syntaxes = array_merge($syntaxes, $e->getSyntaxes());
            } catch (Exception $e) {
                // This is likely caused by a lexer issue. Which means we couldn't pass the syntax
                // anyway.
                $syntaxes = array_merge($syntaxes, array($syntax['syntax']));
            }
        }

        throw new NoMatcherFoundException($syntaxes);
    }
}
