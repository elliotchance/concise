<?php

namespace Concise\Syntax;

use Concise\Matcher\Syntax;
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

    public function testRetrievingTheSameSyntax()
    {
        $syntaxCache = new SyntaxCache();
        $syntax = new Syntax('? equals ?', '\Concise\TestCase::assert');
        $syntaxCache->add($syntax);
        $this->aassert($syntaxCache->getSyntax('?'))->isTheSameAs($syntax);
    }
}
