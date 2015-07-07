<?php

namespace Concise\Syntax;

use Concise\TestCase;

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
        $this->assert($this->expectedTokens(), equals, $this->parsed['tokens']);
    }

    public function testLexerWillReturnSyntaxForString()
    {
        $this->assert($this->expectedSyntax(), equals, $this->parsed['syntax']);
    }

    public function testLexerWillReturnArgumentsForString()
    {
        $this->assert(
            $this->expectedArguments(),
            equals,
            $this->parsed['arguments']
        );
    }

    abstract protected function expectedTokens();

    abstract protected function expectedSyntax();

    abstract protected function expectedArguments();
}
