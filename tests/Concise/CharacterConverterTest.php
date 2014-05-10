<?php

namespace Concise;

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
		);
	}

	/**
	 * @dataProvider stringData
	 */
	public function testConvertingCharacterToEscapedCharacter($ch, $expected)
	{
		$converter = new CharacterConverter();
		$this->assertEquals($expected, $converter->convertEscapedCharacter($ch));
	}
}
