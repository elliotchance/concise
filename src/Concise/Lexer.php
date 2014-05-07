<?php

namespace Concise;

class Lexer
{
	const TOKEN_KEYWORD = 1;

	const TOKEN_ATTRIBUTE = 2;

	const TOKEN_INTEGER = 3;

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
		if(preg_match('/^[0-9]+$/', $token)) {
			return self::TOKEN_INTEGER;
		}
		return self::TOKEN_ATTRIBUTE;
	}

	protected function getTokens($string)
	{
		return explode(' ', $string);
	}

	protected function getAttributes($string)
	{
		$tokens = $this->getTokens($string);
		$attributes = array();
		foreach($tokens as $token) {
			if(!$this->isKeyword($token)) {
				if(preg_match('/^[0-9]+$/', $token)) {
					$attributes[] = $token * 1;
				}
				else {
					$attributes[] = new Attribute();
				}
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
