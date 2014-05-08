<?php

namespace Concise;

class Lexer
{
	const TOKEN_KEYWORD = 1;

	const TOKEN_ATTRIBUTE = 2;

	const TOKEN_INTEGER = 3;

	const TOKEN_FLOAT = 4;

	const TOKEN_STRING = 5;

	protected static function convertEscapedCharacter($ch)
	{
		// @test \cx : "control-x", where x is any character
		// @test \p{xx} : a character with the xx property, see unicode properties for more info
		// @test \P{xx} : a character without the xx property, see unicode properties for more info
		// @test \xhh : character with hex code hh
		// @test \ddd : character with octal code ddd, or backreference
		if($ch === 'a') {
			return "\a";
		}
		if($ch === 'e') {
			return "\e";
		}
		if($ch === 'f') {
			return "\f";
		}
		if($ch === 'n') {
			return "\n";
		}
		if($ch === 'r') {
			return "\r";
		}
		if($ch === 't') {
			return "\t";
		}
	}

	protected static function isKeyword($token)
	{
		return in_array($token, self::getKeywords());
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
		// @test match newlines
		if(preg_match('/^".*"/', $token) || preg_match("/^'.*'/", $token)) {
			return self::TOKEN_STRING;
		}
		return self::TOKEN_ATTRIBUTE;
	}

	protected function consumeString($string, $container, &$startIndex)
	{
		$t = '';
		for($i = $startIndex + 1; $i < strlen($string) && $string[$i] != $container; ++$i) {
			if($string[$i] === "\\") {
				++$i;
				$t .= self::convertEscapedCharacter($string[$i]);
			}
			else {
				$t .= $string[$i];
			}
		}
		$startIndex = $i;
		return $t;
	}

	protected function getTokens($string)
	{
		// @test quotes string that is not closed
		$r = array();
		$t = '';
		for($i = 0; $i < strlen($string); ++$i) {
			$ch = $string[$i];
			if($ch === '"' || $ch === "'") {
				$t = $this->consumeString($string, $ch, $i);
				$r[] = new Token(Lexer::TOKEN_STRING, $t);
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
				case self::TOKEN_ATTRIBUTE:
				default:
					$attributes[] = new Attribute($token->getValue());
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
