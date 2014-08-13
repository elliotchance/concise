<?php

namespace Concise\Syntax;

class LexerFloatTest extends LexerTestCase
{
    protected function assertion()
    {
        return '1.23 equals .45';
    }

    protected function expectedTokens()
    {
        return array(
            new Token\Value(1.23),
            new Token\Keyword('equals'),
            new Token\Value(0.45),
        );
    }

    protected function expectedSyntax()
    {
        return '? equals ?';
    }

    protected function expectedArguments()
    {
        return array(1.23, 0.45);
    }
}
