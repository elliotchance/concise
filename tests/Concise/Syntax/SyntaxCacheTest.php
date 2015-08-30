<?php

namespace Concise\Syntax;

use Concise\Core\Syntax;
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
        $this->aassert($syntaxCache->getSyntax('? equals ?'))
            ->isTheSameAs($syntax);
    }

    public function testRetrievingAnotherSyntax()
    {
        $syntaxCache = new SyntaxCache();
        $syntax1 = new Syntax('? foo ?', '\Concise\TestCase::assert');
        $syntax2 = new Syntax('? bar ?', '\Concise\TestCase::assert');
        $syntaxCache->add($syntax1);
        $syntaxCache->add($syntax2);
        $this->aassert($syntaxCache->getSyntax('? foo ?'))
            ->isTheSameAs($syntax1);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessahe Syntax '? bar ?' already registered.
     */
    public function testAddingTheSameSyntaxThrowsAnException()
    {
        $syntaxCache = new SyntaxCache();
        $syntax = new Syntax('? bar ?', '\Concise\TestCase::assert');
        $syntaxCache->add($syntax);
        $syntaxCache->add($syntax);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessahe Syntax '? bar ?' already registered.
     */
    public function testAddingASimilarSyntaxThrowsAnException()
    {
        $syntaxCache = new SyntaxCache();
        $syntax1 = new Syntax('? bar ?', '\Concise\TestCase::assert');
        $syntax2 = new Syntax('?:int bar ?', '\Concise\TestCase::assert');
        $syntaxCache->add($syntax1);
        $syntaxCache->add($syntax2);
    }

    public function testGetSyntaxBySimilar()
    {
        $syntaxCache = new SyntaxCache();
        $syntax = new Syntax('? equals ?', '\Concise\TestCase::assert');
        $syntaxCache->add($syntax);
        $this->aassert($syntaxCache->getSyntax('?:int equals ?'))
            ->isTheSameAs($syntax);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessahe Syntax '? foo ?' conflicts with '? foo ? bar'.
     */
    public function testCannotAddASubSyntax()
    {
        $syntaxCache = new SyntaxCache();
        $syntax1 = new Syntax('? foo ?', '\Concise\TestCase::assert');
        $syntax2 = new Syntax('? foo ? bar', '\Concise\TestCase::assert');
        $syntaxCache->add($syntax1);
        $syntaxCache->add($syntax2);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessahe Syntax '? foo ?' conflicts with '? foo ? bar'.
     */
    public function testCannotAddASuperSyntax()
    {
        $syntaxCache = new SyntaxCache();
        $syntax1 = new Syntax('? foo ?', '\Concise\TestCase::assert');
        $syntax2 = new Syntax('? foo ? bar', '\Concise\TestCase::assert');
        $syntaxCache->add($syntax2);
        $syntaxCache->add($syntax1);
    }
}
