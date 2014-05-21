<?php

namespace Concise\Syntax;

use \Concise\TestCase;

class CharacterConverterTest extends TestCase
{

	public function stringData()
	{
		return array(
			array("a", "\a"),
			array("e", "\e"),
			array("f", "\f"),
			array("n", "\n"),
			array("r", "\r"),
			array("t", "\t"),
			array("'", "'"),
			array("\\", "\\"),
			array("0", "0"),
			array("w", "w"),
			array("\"", "\""),
		);
	}

	public function _test_converting_character_to_escape_character()
	{
		// @test ? placeholder does not have to be wrapped in {}
		$this->converter = new CharacterConverter();
		return $this->assertionsForDataSet(
			'{$self->converter->convertEscapedCharacter(?)} equals {?}',
			$this->stringData()
		);
	}
}
