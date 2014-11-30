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

    /**
     * @param int $offset
     * @return array
     */
    protected function getData($offset = 0)
    {
        $data = array();
        $argc = count($this->args);
        for ($i = $offset; $i < $argc; $i += 2) {
            $data[$this->getArgName($i - $offset)] = $this->args[$i];
        }

        return $data;
    }

    /**
     * @return array
     */
    protected function getAlternateData()
    {
        return $this->getData(1);
    }

    /**
     * @return array
     */
    protected function getOnErrorData()
    {
        $data1 = $this->getData();
        $data2 = $this->getAlternateData();
        $arg = "arg" . (count($data1) - 1);
        $data1[$arg] = $data2[$arg];
        return $data1;
    }

    /**
     * @param array $syntax
     * @param int $offset
     * @return string
     */
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

    /**
     * @return string
     */
    protected function getAlternateSyntaxString()
    {
        return $this->getSyntaxString(array($this->args[0]), 1);
    }

    /**
     * @return string
     */
    protected function getOnErrorSyntaxString()
    {
        $syntax1 = explode(' ', $this->getSyntaxString());
        $syntax2 = explode(' ', $this->getAlternateSyntaxString());
        $syntax = array_merge(array_slice($syntax1, 0, count($syntax1) - 2), array_slice($syntax2, count($syntax1) - 3));
        return implode(' ', $syntax);
    }

    /**
     * @return array
     */
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

        if (count($this->args) > 2 && 'on error' === $this->args[2]) {
            $syntaxes[] = array(
                'syntax' => $this->getOnErrorSyntaxString(),
                'data' => $this->getOnErrorData(),
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
