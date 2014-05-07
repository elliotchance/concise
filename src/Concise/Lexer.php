<?php

namespace Concise;

class Lexer
{
	protected function isKeyword($token)
	{
		$parser = new MatcherParser();
		$keywords = $parser->getKeywords();
		return in_array($token, $keywords);
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
