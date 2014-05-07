<?php

namespace Concise;

class LexerTest extends TestCase
{
	public function tokenData()
	{
		return array(
			'keyword' => array(Lexer::TOKEN_KEYWORD, 'equals'),
			'attribute' => array(Lexer::TOKEN_ATTRIBUTE, 'z'),
			'integer' => array(Lexer::TOKEN_INTEGER, '123')
		);
	}

	/**
	 * @dataProvider tokenData
	 */
	public function testReadKeywordToken($expectedToken, $token)
	{
		$this->assertEquals($expectedToken, Lexer::getTokenType($token));
	}
}
