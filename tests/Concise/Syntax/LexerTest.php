<?php

namespace Concise\Syntax;

use \Concise\TestCase;

class LexerTest extends TestCase
{
	public function tokenData()
	{
		return array(
			'keyword' => array('equals', new Token\Keyword('equals')),
			'attribute' => array('z', new Token\Attribute('z')),
			'integer1' => array('123', new Token\Value('123')),
			'integer2' => array('-123', new Token\Value('-123')),
			'integer3' => array('-123e10', new Token\Value('-123e10')),
			'integer4' => array('-123e-10', new Token\Value('-123e-10')),
			'integer5' => array('-123E10', new Token\Value('-123E10')),
			'integer6' => array('-123E+10', new Token\Value('-123E+10')),
			'float1' => array('1.23', new Token\Value('1.23')),
			'float2' => array('.23', new Token\Value('.23')),
			'float3' => array('-1.23', new Token\Value('-1.23')),
			'float4' => array('-.23', new Token\Value('-.23')),
			'float5' => array('1.23e2', new Token\Value('1.23e2')),
			'float6' => array('1.23E2', new Token\Value('1.23E2')),
			'float7' => array('1.23e+2', new Token\Value('1.23e+2')),
			'float8' => array('1.23E-2', new Token\Value('1.23E-2')),
			'string1' => array('"abc"', new Token\Value('abc')),
			'string2' => array("'abc'", new Token\Value("abc")),
			'string3' => array('"a\nbc"', new Token\Value("a\nbc")),
			'string4' => array("'a\nbc'", new Token\Value("a\nbc")),
			'string5' => array("\MyClass", new Token\Value("MyClass")),
			'code1' => array("`abc`", new Token\Code("abc")),
			'code2' => array("`ab\nc`", new Token\Code("ab\nc")),
			'regexp1' => array("/abc/", new Token\Regexp("abc")),
			'array' => array("[]", new Token\Value(array())),
		);
	}

	/**
	 * @dataProvider tokenData
	 */
	public function testReadKeywordToken($string, $expectedToken)
	{
		$lexer = new Lexer();
		$result = $lexer->parse($string);
		$this->assert($expectedToken, equals, $result['tokens'][0]);
	}

	public function testTokensReturnsAnArrayWithABlankString()
	{
		$lexer = new Lexer();
		$result = $lexer->parse('');
		$this->assert(count($result['tokens']), equals, 0);
	}

	public function testLexerIgnoresBlankTokens()
	{
		$lexer = new Lexer();
		$result = $lexer->parse(' not not  not   not ');
		$this->assert(count($result['tokens']), equals, 4);
	}

	public function testTokensHaveUniqueValues()
	{
		$class = new \ReflectionClass('\Concise\Syntax\Lexer');
		$this->assert($class->getConstants(), is_unique);
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
		$this->assert(array(new Token\Value($expected)), equals, $result['tokens']);
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Expected " before end of string.
	 */
	public function testLexerThrowsExceptionIfDoubleQuotedStringIsNotClosed()
	{
		$lexer = new Lexer();
		$lexer->parse('"abc');
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Expected ' before end of string.
	 */
	public function testLexerThrowsExceptionIfSingleQuotedStringIsNotClosed()
	{
		$lexer = new Lexer();
		$lexer->parse("'abc");
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Invalid JSON: [abc
	 */
	public function testLexerThrowsExceptionIfArrayIsNotValid()
	{
		$lexer = new Lexer();
		$lexer->parse('[abc');
	}

	public function testLexerCanExtractExpectedTypeFromSyntax()
	{
		$lexer = new Lexer();
		$result = $lexer->parse('?:int');
		$this->assert($result['arguments'][0]->getAcceptedTypes(), equals, array('int'));
	}

	public function testLexerCanExtractExpectedTypesFromSyntax()
	{
		$lexer = new Lexer();
		$result = $lexer->parse('?:int,float');
		$this->assert($result['arguments'][0]->getAcceptedTypes(), equals, array('int', 'float'));
	}

	public function testLexerWillNotPutExpectedTypesInAttributeValue()
	{
		$lexer = new Lexer();
		$result = $lexer->parse('?:int,float');
		$this->assert($result['arguments'][0]->getValue(), equals, '?');
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Invalid JSON: [abc:123]
	 */
	public function testLexerThrowsExceptionIfAssociativeArrayIsNotValid()
	{
		$lexer = new Lexer();
		$lexer->parse('[abc:123]');
	}
}
