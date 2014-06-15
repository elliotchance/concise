<?php

namespace Concise\Services;

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

	/**
	 * @dataProvider stringData
	 */
	public function testConvertingCharacterToEscapeCharacter($letter, $outcome)
	{
		$this->converter = new CharacterConverter();
		$this->letter = $letter;
		$this->outcome = $outcome;
		$this->assert('`$self->converter->convertEscapedCharacter($self->letter)` equals `$self->outcome`');
	}
}
