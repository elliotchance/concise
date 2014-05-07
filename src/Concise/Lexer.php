<?php

namespace Concise;

class Lexer
{
	const TOKEN_KEYWORD = 1;

	const TOKEN_ATTRIBUTE = 2;

	const TOKEN_INTEGER = 3;

	const TOKEN_FLOAT = 4;

	const TOKEN_STRING = 5;

	// @test TOKEN_STRING with spaces

	// @test TOKEN_STRING with escaped quotes

	// @test TOKEN_STRING with escaped characters

	// @test TOKEN_ have unique values

	// @test keywords should be generated automatically from matchers
	protected static $keywords = array(
		'equal',
		'equals',
		'is',
		'null',
		'to',
		'true'
	);

	protected static function isKeyword($token)
	{
		return in_array($token, self::$keywords);
	}

	public static function getTokenType($token)
	{
		if(self::isKeyword($token)) {
			return self::TOKEN_KEYWORD;
		}
		if(preg_match('/^[0-9]*\.[0-9]+$/', $token)) {
			return self::TOKEN_FLOAT;
		}
		if(preg_match('/^[0-9]+$/', $token)) {
			return self::TOKEN_INTEGER;
		}
		if(preg_match('/^".*"/', $token) || preg_match("/^'.*'/", $token)) {
			return self::TOKEN_STRING;
		}
		return self::TOKEN_ATTRIBUTE;
	}

	protected function getTokens($string)
	{
		if($string == '') {
			return array();
		}
		return explode(' ', $string);
	}

	protected function getAttributes($string)
	{
		$tokens = $this->getTokens($string);
		$attributes = array();
		foreach($tokens as $token) {
			switch(self::getTokenType($token)) {
				case self::TOKEN_KEYWORD:
					break;
				case self::TOKEN_INTEGER:
				case self::TOKEN_FLOAT:
					$attributes[] = $token * 1;
					break;
				case self::TOKEN_STRING:
					$attributes[] = substr($token, 1, strlen($token) - 2);
					break;
				case self::TOKEN_ATTRIBUTE:
				default:
					$attributes[] = new Attribute($token);
					break;
			}
		}
		return $attributes;
	}

	protected function getSyntax($string)
	{
		$tokens = $this->getTokens($string);
		$syntax = array();
		foreach($tokens as $token) {
			if(self::getTokenType($token) !== self::TOKEN_KEYWORD) {
				$syntax[] = '?';
			}
			else {
				$syntax[] = $token;
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
		return self::$keywords;
	}
}
