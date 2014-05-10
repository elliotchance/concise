<?php

namespace Concise;

class CharacterConverter
{
	public function convertEscapedCharacter($ch)
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
}
