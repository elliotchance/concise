<?php

namespace Concise\Syntax;

use \Concise\Syntax\Attribute;
use \Concise\Services\CharacterConverter;

class Lexer
{
	const TOKEN_KEYWORD = 1;

	const TOKEN_ATTRIBUTE = 2;

	const TOKEN_INTEGER = 3;

	const TOKEN_FLOAT = 4;

	const TOKEN_STRING = 5;

	const TOKEN_CODE = 6;

	const TOKEN_REGEXP = 7;

	protected static function isKeyword($token)
	{
		return in_array($token, self::getKeywords());
	}

	public static function getTokenType($token)
	{
		if(self::isKeyword($token)) {
			return self::TOKEN_KEYWORD;
		}
		if(preg_match('/^\-?[0-9]*\.[0-9]+([eE][\-+]?[0-9]+)?$/', $token)) {
			return self::TOKEN_FLOAT;
		}
		if(preg_match('/^\-?[0-9]+([eE][\-+]?[0-9]+)?$/', $token)) {
			return self::TOKEN_INTEGER;
		}
		if(preg_match('/^".*"/ms', $token) || preg_match("/^'.*'/ms", $token) || "\\" === substr($token, 0, 1)) {
			return self::TOKEN_STRING;
		}
		if(preg_match('/^`.*`/ms', $token)) {
			return self::TOKEN_CODE;
		}
		if(preg_match('|^/|ms', $token)) {
			return self::TOKEN_REGEXP;
		}
		return self::TOKEN_ATTRIBUTE;
	}

	protected function consumeUntilToken($string, $until, &$startIndex, $mustConsumeUntil = true)
	{
		$t = '';
		for($i = $startIndex + 1; $string[$i] != $until; ++$i) {
			if($i == strlen($string) - 1) {
				if($mustConsumeUntil) {
					throw new \Exception("Expected $until before end of string.");
				}
				$t .= $string[$i];
				break;
			}
			if(($until === "'" || $until === '"') && $string[$i] === "\\") {
				++$i;
				$converter = new CharacterConverter();
				$t .= $converter->convertEscapedCharacter($string[$i]);
			}
			else {
				$t .= $string[$i];
			}
		}
		$startIndex = $i;
		return $t;
	}

	protected function consumeString($string, $container, &$startIndex)
	{
		return $this->consumeUntilToken($string, $container, $startIndex);
	}

	protected function consumeClassname($string, &$startIndex)
	{
		return $this->consumeUntilToken($string, ' ', $startIndex, false);
	}

	protected function consumeCode($string, &$startIndex)
	{
		return $this->consumeUntilToken($string, '`', $startIndex);
	}

	protected function consumeRegexp($string, &$startIndex)
	{
		return $this->consumeUntilToken($string, '/', $startIndex);
	}

	protected function getTokens($string)
	{
		$r = array();
		$t = '';
		for($i = 0; $i < strlen($string); ++$i) {
			$ch = $string[$i];
			if($ch === '"' || $ch === "'") {
				$t = $this->consumeString($string, $ch, $i);
				$r[] = new Token(Lexer::TOKEN_STRING, $t);
				$t = '';
			}
			else if($ch === "\\") {
				$t = $this->consumeClassname($string, $i);
				$r[] = new Token(Lexer::TOKEN_STRING, $t);
				$t = '';
			}
			else if($ch === '`') {
				$t = $this->consumeCode($string, $i);
				$r[] = new Token(Lexer::TOKEN_CODE, $t);
				$t = '';
			}
			else if($ch === '/') {
				$t = $this->consumeRegexp($string, $i);
				$r[] = new Token(Lexer::TOKEN_REGEXP, $t);
				$t = '';
			}
			else if($ch === ' ') {
				if($t !== '') {
					$r[] = new Token(self::getTokenType($t), $t);
					$t = '';
				}
			}
			else {
				$t .= $ch;
			}
		}
		if($t !== '') {
			$r[] = new Token(self::getTokenType($t), $t);
		}
		return $r;
	}

	protected function getAttributes($string)
	{
		$tokens = $this->getTokens($string);
		$attributes = array();
		foreach($tokens as $token) {
			switch($token->getType()) {
				case self::TOKEN_KEYWORD:
					break;
				case self::TOKEN_INTEGER:
				case self::TOKEN_FLOAT:
					$attributes[] = $token->getValue() * 1;
					break;
				case self::TOKEN_STRING:
					$attributes[] = $token->getValue();
					break;
				case self::TOKEN_CODE:
					$attributes[] = new Code($token->getValue());
					break;
				case self::TOKEN_ATTRIBUTE:
				default:
					$attributes[] = new Attribute($token->getValue());
					break;
				// @test default: throws exception
			}
		}
		return $attributes;
	}

	protected function getSyntax($string)
	{
		$tokens = $this->getTokens($string);
		$syntax = array();
		foreach($tokens as $token) {
			if($token->getType() !== self::TOKEN_KEYWORD) {
				$syntax[] = '?';
			}
			else {
				$syntax[] = $token->getValue();
			}
		}
		return implode(' ', $syntax);
	}

	public function parse($string)
	{
		return array(
			'tokens' => $this->getTokens($string),
			'syntax' => $this->getSyntax($string),
			'arguments' => $this->getAttributes($string)
		);
	}

	public static function getKeywords()
	{
		return MatcherParser::getInstance()->getKeywords();
	}
}
