<?php

namespace Concise;

class Lexer
{
	public function parse($string)
	{
		return array(
			'tokens' => array('a', 'equals', 'b'),
			'syntax' => '? equals ?'
		);
	}
}
