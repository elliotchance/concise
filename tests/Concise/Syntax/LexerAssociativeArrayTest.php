<?php

namespace Concise\Syntax;

class LexerAssociativeArrayTest extends LexerTestCase
{
    protected function assertion()
    {
        return '["abc":123] ["abc":"123"]';
    }

    protected function expectedTokens()
    {
        return array(
            new Token\Value(array("abc" => 123)),
            new Token\Value(array("abc" => "123")),
        );
    }

    protected function expectedSyntax()
    {
        return '? ?';
    }

    protected function expectedArguments()
    {
        return array(array("abc" => 123), array("abc" => "123"));
    }
}
