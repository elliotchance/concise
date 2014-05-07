<?php

namespace Concise;

class LexerTestCase extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->lexer = new Lexer();
		$this->result = $this->lexer->parse($this->assertion());
	}

	public function testLexerWillReturnTokensForString()
	{
		$this->assertEquals($this->expectedTokens(), $this->result['tokens']);
	}

	public function testLexerWillReturnSyntaxForString()
	{
		$this->assertEquals($this->expectedSyntax(), $this->result['syntax']);
	}

	public function testLexerWillReturnArgumentsForString()
	{
		$this->assertEquals($this->expectedArguments(), $this->result['arguments']);
	}
}
