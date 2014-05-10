<?php

namespace Concise;

class CharacterConverter
{
	protected $characterMap = array(
		'a' => "\a",
		'e' => "\e",
		'f' => "\f",
		'n' => "\n",
		'r' => "\r",
		't' => "\t",
	);

	public function convertEscapedCharacter($ch)
	{
		// @test \cx : "control-x", where x is any character
		// @test \p{xx} : a character with the xx property, see unicode properties for more info
		// @test \P{xx} : a character without the xx property, see unicode properties for more info
		// @test \xhh : character with hex code hh
		// @test \ddd : character with octal code ddd, or backreference
		if(array_key_exists($ch, $this->characterMap)) {
			return $this->characterMap[$ch];
		}
		return $ch;
	}
}
