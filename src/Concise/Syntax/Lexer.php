<?php

namespace Concise\Syntax;

use Concise\Services\CharacterConverter;

class Lexer
{
    /**
	 * @var \Concise\Syntax\MatcherParser
	 */
    protected $matcherParser = null;

    /**
	 * @return Concise\Syntax\MatcherParser
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
                if ($mustConsumeUntil) {
                    throw new \Exception("Expected $until before end of string.");
                }
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
	 * @param  string $string
	 * @param  string $container
	 * @param  integer $startIndex
	 * @return string
	 */
    protected function consumeString($string, $container, &$startIndex)
    {
        return $this->consumeUntilToken($string, $container, $startIndex);
    }

    /**
	 * @param  string $string
	 * @param  integer $startIndex
	 * @return string
	 */
    protected function consumeClassname($string, &$startIndex)
    {
        return $this->consumeUntilToken($string, ' ', $startIndex, false);
    }

    /**
	 * @param  string $string
	 * @param  integer $startIndex
	 * @return string
	 */
    protected function consumeRegexp($string, &$startIndex)
    {
        return '/' . $this->consumeUntilToken($string, '/', $startIndex) . '/';
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
	 * @param  string $string
	 * @param  integer $startIndex
	 * @return string
	 */
    protected function consumeJson($string, &$startIndex)
    {
        $originalStartIndex = $startIndex;
        $len = strlen($string);
        for ($i = 2; $startIndex + $i <= $len; ++$i) {
            $json = substr($string, $startIndex, $i);
            $value = json_decode($json);
            if (null !== $value) {
                $startIndex += $i;

                return $value;
            }
            if (substr($json, 0, 1) === '[' && substr($json, strlen($json) - 1, 1) === ']') {
                $json = '{' . substr($json, 1, strlen($json) - 2) . '}';
                $value = json_decode($json, true);
                if (null !== $value) {
                    $startIndex += $i;

                    return $value;
                }
            }
        }
        throw new \Exception("Invalid JSON: " . substr($string, $originalStartIndex));
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
            $ch = $string[$i];
            if ($ch === '"' || $ch === "'") {
                $t = $this->consumeString($string, $ch, $i);
                $r[] = new Token\Value($t);
                $t = '';
            } elseif ($ch === "\\") {
                $t = $this->consumeClassname($string, $i);
                $r[] = new Token\Value($t);
                $t = '';
            } elseif ($ch === '/') {
                $t = $this->consumeRegexp($string, $i);
                $r[] = new Token\Regexp($t);
                $t = '';
            } elseif ($ch === '[' || $ch === '{') {
                $t = $this->consumeJson($string, $i);
                $r[] = new Token\Value($t);
                $t = '';
            } elseif ($ch === ' ') {
                if ($t !== '') {
                    $r[] = $this->translateValue($t);
                    $t = '';
                }
            } else {
                $t .= $ch;
            }
        }
        if ($t !== '') {
            $r[] = $this->translateValue($t);
        }

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
