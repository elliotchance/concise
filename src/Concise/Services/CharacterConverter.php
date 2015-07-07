<?php

namespace Concise\Services;

class CharacterConverter
{
    /**
     * @var array
     */
    protected $characterMap = array(
        'a' => "\a",
        'e' => "\e",
        'f' => "\f",
        'n' => "\n",
        'r' => "\r",
        't' => "\t",
    );

    /**
     * @param  string $ch A string character.
     * @return string
     */
    public function convertEscapedCharacter($ch)
    {
        // @test \cx : "control-x", where x is any character
        // @test \p{xx} : a character with the xx property, see unicode properties for more info
        // @test \P{xx} : a character without the xx property, see unicode properties for more info
        // @test \xhh : character with hex code hh
        // @test \ddd : character with octal code ddd, or back reference
        if (array_key_exists($ch, $this->characterMap)) {
            return $this->characterMap[$ch];
        }

        return $ch;
    }
}
