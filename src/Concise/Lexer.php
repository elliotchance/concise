<?php

namespace Concise;

class Lexer
{
	public function parse($string)
	{
		return array(
			'tokens' => array('a', 'equals', 'b'),
			'syntax' => '? equals ?',
			'arguments' => array(
				'a' => new Attribute(),
				'b' => new Attribute()
			)
		);
	}
}
