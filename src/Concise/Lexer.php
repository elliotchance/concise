<?php

namespace Concise;

class Lexer
{
	const TOKEN_KEYWORD = 1;

	const TOKEN_ATTRIBUTE = 2;

	const TOKEN_INTEGER = 3;

	const TOKEN_FLOAT = 4;

	const TOKEN_STRING = 5;

	// @test TOKEN_ have unique values

	protected static function isKeyword($token)
	{
		$parser = new MatcherParser();
		$keywords = $parser->getKeywords();
		return in_array($token, $keywords);
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
		if(preg_match('/^".*"/', $token)) {
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
					$attributes[] = $token * 1;
					break;
				case self::TOKEN_ATTRIBUTE:
				default:
					$attributes[] = new Attribute();
					break;
			}
		}
		return $attributes;
	}

	public function parse($string)
	{
		return array(
			'tokens' => $this->getTokens($string),
			'syntax' => '? equals ?',
			'arguments' => $this->getAttributes($string)
		);
	}
}
