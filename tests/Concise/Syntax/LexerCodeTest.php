<?php

namespace Concise\Syntax;

use \Concise\Syntax\Token\Attribute;

class LexerCodeTest extends LexerTestCase
{
    protected function assertion()
    {
        return '`1 + 2` equals b';
    }

    protected function expectedTokens()
    {
        return array(
            new Token\Code('1 + 2'),
            new Token\Keyword('equals'),
            new Token\Attribute('b'),
        );
    }

    protected function expectedSyntax()
    {
        return '? equals ?';
    }

    protected function expectedArguments()
    {
        return array(new Token\Code('1 + 2'), new Token\Attribute('b'));
    }
}
