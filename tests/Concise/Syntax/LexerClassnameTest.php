<?php

namespace Concise\Syntax;

use Concise\Syntax\Token\Attribute;

class LexerClassnameTest extends LexerTestCase
{
    protected function assertion()
    {
        return 'x equals \My\Class';
    }

    protected function expectedTokens()
    {
        return array(
            new Token\Attribute('x'),
            new Token\Keyword('equals'),
            new Token\Value('My\Class'),
        );
    }

    protected function expectedSyntax()
    {
        return '? equals ?';
    }

    protected function expectedArguments()
    {
        return array(new Attribute('x'), 'My\Class');
    }
}
