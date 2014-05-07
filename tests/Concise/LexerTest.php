<?php

namespace Concise;

class LexerTest extends TestCase
{
	public function tokenData()
	{
		return array(
			'keyword' => array(Lexer::TOKEN_KEYWORD, 'equals'),
			'attribute' => array(Lexer::TOKEN_ATTRIBUTE, 'z'),
			'integer' => array(Lexer::TOKEN_INTEGER, '123'),
			'float1' => array(Lexer::TOKEN_FLOAT, '1.23'),
			'float2' => array(Lexer::TOKEN_FLOAT, '.23'),
			'string1' => array(Lexer::TOKEN_STRING, '"abc"'),
			'string2' => array(Lexer::TOKEN_STRING, "'abc'")
		);
	}

	/**
	 * @dataProvider tokenData
	 */
	public function testReadKeywordToken($expectedToken, $token)
	{
		$this->assertEquals($expectedToken, Lexer::getTokenType($token));
	}

	public function testTokensReturnsAnArrayWithABlankString()
	{
		$lexer = new Lexer();
		$result = $lexer->parse('');
		$this->assertCount(0, $result['tokens']);
	}

	public function testKeywordsReturnsArray()
	{
		$this->assertTrue(is_array(Lexer::getKeywords()));
	}

	public function testKeywordsAreUnique()
	{
		$keywords = Lexer::getKeywords();
		$this->assertCount(count($keywords), array_unique($keywords));
	}

	public function testKeywordsAreSorted()
	{
		$keywords = Lexer::getKeywords();
		$sortedKeywords = Lexer::getKeywords();
		sort($sortedKeywords);
		$this->assertEquals($keywords, $sortedKeywords);
	}

	public function testLexerIgnoresBlankTokens()
	{
		$lexer = new Lexer();
		$result = $lexer->parse(' not not  not   not ');
		$this->assertCount(4, $result['tokens']);
	}

	public function testTokensHaveUniqueValues()
	{
		$class = new \ReflectionClass('\Concise\Lexer');
		$constants = $class->getConstants();
		$this->assertEquals(count($constants), count(array_unique($constants)));
	}

	public function stringData()
	{
		return array(
			array('"not abc"', array('"not abc"')),
			array("'not abc'", array('"not abc"')),
		);
	}

	/**
	 * @dataProvider stringData
	 */
	public function testTokenizerAllowsDoubleQuotedStringsWithSpaces($string, $expected)
	{
		$lexer = new Lexer();
		$result = $lexer->parse($string);
		$this->assertEquals($expected, $result['tokens']);
	}
}
