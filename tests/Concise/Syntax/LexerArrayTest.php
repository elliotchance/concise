<?php

namespace Concise\Syntax;

class LexerArrayTest extends LexerTestCase
{
    protected function assertion()
    {
        return '[] equals [123,"abc"]';
    }

    protected function expectedTokens()
    {
        return array(
            new Token\Value(array()),
            new Token\Keyword('equals'),
            new Token\Value(array(123, "abc")),
        );
    }

    protected function expectedSyntax()
    {
        return '? equals ?';
    }

    protected function expectedArguments()
    {
        return array(array(), array(123, "abc"));
    }
}
