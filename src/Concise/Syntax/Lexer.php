<?php

namespace Concise\Syntax;

use Concise\Services\CharacterConverter;
use Concise\Validation\ArgumentChecker;
use Exception;

class Lexer
{
    /**
	 * @var \Concise\Syntax\MatcherParser
	 */
    protected $matcherParser = null;

    /**
	 * @return \Concise\Syntax\MatcherParser
	 */
    protected function getMatcherParser()
    {
        if (null === $this->matcherParser) {
            $this->setMatcherParser(MatcherParser::getInstance());
        }

        return $this->matcherParser;
    }

    /**
	 * @param string $token
	 * @return bool
	 */
    protected function isKeyword($token)
    {
        return in_array($token, $this->getMatcherParser()->getKeywords());
    }

    /**
     * @param boolean $mustConsumeUntil
     * @param string $until
     */
    protected function throwExceptionIfWeMustConsumeUntil($mustConsumeUntil, $until)
    {
        if ($mustConsumeUntil) {
            throw new Exception("Expected $until before end of string.");
        }
    }

    /**
	 * @param  string $string
	 * @param  string $until A single character.
	 * @param  integer $startIndex
	 * @param  boolean $mustConsumeUntil
	 * @return string
	 */
    protected function consumeUntilToken($string, $until, &$startIndex, $mustConsumeUntil = true)
    {
        $t = '';
        for ($i = $startIndex + 1; $string[$i] != $until; ++$i) {
            if ($i == strlen($string) - 1) {
                $this->throwExceptionIfWeMustConsumeUntil($mustConsumeUntil, $until);
                $t .= $string[$i];
                break;
            }
            if (($until === "'" || $until === '"') && $string[$i] === "\\") {
                ++$i;
                $converter = new CharacterConverter();
                $t .= $converter->convertEscapedCharacter($string[$i]);
            } else {
                $t .= $string[$i];
            }
        }
        $startIndex = $i;

        return $t;
    }

    /**
     * @param array $tokens
	 * @param  string $string
	 * @param  integer $startIndex
	 * @return string
	 */
    protected function consumeString(array &$tokens, $string, &$startIndex)
    {
        if ($string[$startIndex] === '"' || $string[$startIndex] === "'") {
            $tokens[] = new Token\Value($this->consumeUntilToken($string, $string[$startIndex], $startIndex));
        }
    }

    /**
     * @param array $tokens
	 * @param  string $string
	 * @param  integer $startIndex
	 * @return string
	 */
    protected function consumeClassName(array &$tokens, $string, &$startIndex)
    {
        if ($string[$startIndex] === "\\") {
            $tokens[] = new Token\Value($this->consumeUntilToken($string, ' ', $startIndex, false));
        }
    }

    /**
     * @param array $tokens
	 * @param  string $string
	 * @param  integer $startIndex
	 * @return string
	 */
    protected function consumeRegexp(array &$tokens, $string, &$startIndex)
    {
        if ($string[$startIndex] === '/') {
            $tokens[] = new Token\Regexp('/' . $this->consumeUntilToken($string, '/', $startIndex) . '/');
        }
    }

    /**
	 * @param string $t
	 * @return Token
	 */
    protected function translateValue($t)
    {
        if ($this->isKeyword($t)) {
            return new Token\Keyword($t);
        }
        if(preg_match('/^\-?[0-9]*\.[0-9]+([eE][\-+]?[0-9]+)?$/', $t) ||
            preg_match('/^\-?[0-9]+([eE][\-+]?[0-9]+)?$/', $t)) {
            return new Token\Value($t * 1);
        }

        return new Token\Attribute($t);
    }

    /**
     * @param array $tokens
     * @param  string $string
     * @param  integer $startIndex
     * @throws Exception
     * @return string
     */
    protected function consumeJson(array &$tokens, $string, &$startIndex)
    {
        if ($string[$startIndex] === '[' || $string[$startIndex] === '{') {
            $originalStartIndex = $startIndex;
            $len = strlen($string);
            for ($i = 2; $startIndex + $i <= $len; ++$i) {
                $json = substr($string, $startIndex, $i);
                $value = json_decode($json);
                if (null !== $value) {
                    $startIndex += $i;

                    $tokens[] = new Token\Value($value);

                    return;
                }
            }
            throw new Exception("Invalid JSON: " . substr($string, $originalStartIndex));
        }
    }

    /**
     * @param string $string
     */
    protected function consumeToken(array &$tokens, $string, &$startIndex)
    {
        $currentTokens = count($tokens);
        $this->consumeString($tokens, $string, $startIndex);
        $this->consumeClassname($tokens, $string, $startIndex);
        $this->consumeRegexp($tokens, $string, $startIndex);
        $this->consumeJson($tokens, $string, $startIndex);

        return $currentTokens !== count($tokens);
    }

    /**
     * @param string $token
     */
    protected function addTokenIfNotEmpty(array &$tokens, $token)
    {
        $token = trim($token);
        if ($token !== '') {
            $tokens[] = $this->translateValue($token);
        }
    }

    /**
	 * @param  string $string
	 * @return array
	 */
    protected function getTokens($string)
    {
        $r = array();
        $t = '';
        $len = strlen($string);
        for ($i = 0; $i < $len; ++$i) {
            if ($this->consumeToken($r, $string, $i)) {
                continue;
            }

            $ch = $string[$i];
            $t .= $ch;
            if ($ch === ' ') {
                $this->addTokenIfNotEmpty($r, $t);
                $t = '';
            }
        }
        $this->addTokenIfNotEmpty($r, $t);

        return $r;
    }

    /**
	 * @param  string $string
	 * @return array
	 */
    protected function getAttributes($string)
    {
        $tokens = $this->getTokens($string);
        $attributes = array();
        foreach ($tokens as $token) {
            if ($token instanceof Token\Keyword) {
                continue;
            }
            if ($token instanceof Token\Value) {
                $attributes[] = $token->getValue();
            } else {
                $attributes[] = $token;
            }
        }

        return $attributes;
    }

    /**
	 * @param  string $string
	 * @return string
	 */
    protected function getSyntax($string)
    {
        $tokens = $this->getTokens($string);
        $syntax = array();
        foreach ($tokens as $token) {
            if (!($token instanceof Token\Keyword)) {
                $syntax[] = '?';
            } else {
                $syntax[] = $token->getValue();
            }
        }

        return implode(' ', $syntax);
    }

    /**
	 * @param  string $string
	 * @return array
	 */
    public function parse($string)
    {
        ArgumentChecker::check($string, 'string');

        return array(
            'tokens' => $this->getTokens($string),
            'syntax' => $this->getSyntax($string),
            'arguments' => $this->getAttributes($string)
        );
    }

    /**
	 * @param \Concise\Syntax\MatcherParser $matcherParser
	 */
    public function setMatcherParser(MatcherParser $matcherParser)
    {
        $this->matcherParser = $matcherParser;
    }
}
