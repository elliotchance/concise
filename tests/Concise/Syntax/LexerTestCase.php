<?php

namespace Concise\Syntax;

use \Concise\TestCase;

abstract class LexerTestCase extends TestCase
{
	/** @var Lexer */
	protected $lexer;

	/**
	 * @var array
	 */
	protected $parsed;

	public function setUp()
	{
		parent::setUp();
		$this->lexer = new Lexer();
		$this->parsed = $this->lexer->parse($this->assertion());
	}

	public function testLexerWillReturnTokensForString()
	{
		$this->assertEquals($this->expectedTokens(), $this->parsed['tokens']);
	}

	public function testLexerWillReturnSyntaxForString()
	{
		$this->assertEquals($this->expectedSyntax(), $this->parsed['syntax']);
	}

	public function testLexerWillReturnArgumentsForString()
	{
		$this->assertEquals($this->expectedArguments(), $this->parsed['arguments']);
	}

	protected abstract function expectedTokens();

	protected abstract function expectedSyntax();

	protected abstract function expectedArguments();
}
