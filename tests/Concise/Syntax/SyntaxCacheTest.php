<?php

namespace Concise\Syntax;

use Concise\TestCase;

class SyntaxCacheTest extends TestCase
{
    /**
     * @expectedException \Exception
     * @expectedExceptionMessahe No such syntax '?'
     */
    public function testGettingSyntaxThatDoesntExistThrowsException()
    {
        $syntaxCache = new SyntaxCache();
        $syntaxCache->getSyntax('?');
    }
}
