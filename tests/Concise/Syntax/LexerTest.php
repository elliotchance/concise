<?php

namespace Concise\Syntax;

use \Concise\TestCase;

class LexerTest extends TestCase
{
	public function tokenData()
	{
		return array(
			'keyword' => array(Lexer::TOKEN_KEYWORD, 'equals'),
			'attribute' => array(Lexer::TOKEN_ATTRIBUTE, 'z'),
			'integer1' => array(Lexer::TOKEN_INTEGER, '123'),
			'integer2' => array(Lexer::TOKEN_INTEGER, '-123'),
			'integer3' => array(Lexer::TOKEN_INTEGER, '-123e10'),
			'integer4' => array(Lexer::TOKEN_INTEGER, '-123e-10'),
			'integer5' => array(Lexer::TOKEN_INTEGER, '-123E10'),
			'integer6' => array(Lexer::TOKEN_INTEGER, '-123E+10'),
			'float1' => array(Lexer::TOKEN_FLOAT, '1.23'),
			'float2' => array(Lexer::TOKEN_FLOAT, '.23'),
			'float3' => array(Lexer::TOKEN_FLOAT, '-1.23'),
			'float4' => array(Lexer::TOKEN_FLOAT, '-.23'),
			'float5' => array(Lexer::TOKEN_FLOAT, '1.23e2'),
			'float6' => array(Lexer::TOKEN_FLOAT, '1.23E2'),
			'float7' => array(Lexer::TOKEN_FLOAT, '1.23e+2'),
			'float8' => array(Lexer::TOKEN_FLOAT, '1.23E-2'),
			'string1' => array(Lexer::TOKEN_STRING, '"abc"'),
			'string2' => array(Lexer::TOKEN_STRING, "'abc'"),
			'string3' => array(Lexer::TOKEN_STRING, '"a\nbc"'),
			'string4' => array(Lexer::TOKEN_STRING, "'a\nbc'"),
			'string5' => array(Lexer::TOKEN_STRING, "\MyClass"),
			'code1' => array(Lexer::TOKEN_CODE, "`abc`"),
			'code2' => array(Lexer::TOKEN_CODE, "`ab\nc`"),
			'array' => array(Lexer::TOKEN_ARRAY, "[]"),
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
		$class = new \ReflectionClass('\Concise\Syntax\Lexer');
		$constants = $class->getConstants();
		$this->assertEquals(count($constants), count(array_unique($constants)));
	}

	public function stringData()
	{
		return array(
			array('"not abc"', 'not abc'),
			array("'not abc'", 'not abc'),
			array("'not \"abc'", 'not "abc'),
			array('"not \'abc"', "not 'abc"),
			array("'a\\ab'", "a\ab"),
		);
	}

	/**
	 * @dataProvider stringData
	 */
	public function testTokenizerUnderstandsStrings($string, $expected)
	{
		$lexer = new Lexer();
		$result = $lexer->parse($string);
		$this->assertEquals(array(new Token(Lexer::TOKEN_STRING, $expected)), $result['tokens']);
	}

	public function testLexerUsesKeywordsFromMatcherParser()
	{
		$this->assertEquals(Lexer::getKeywords(), MatcherParser::getInstance()->getKeywords());
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Expected " before end of string.
	 */
	public function testLexerThrowsExceptionIfDoubleQuotedStringIsNotClosed()
	{
		$lexer = new Lexer();
		$result = $lexer->parse('"abc');
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Expected ' before end of string.
	 */
	public function testLexerThrowsExceptionIfSingleQuotedStringIsNotClosed()
	{
		$lexer = new Lexer();
		$result = $lexer->parse("'abc");
	}
}
