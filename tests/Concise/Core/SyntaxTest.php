<?php

namespace Concise\Core;

use Concise\Core\TestCase;

class SyntaxTest extends TestCase
{
    public function testGetSyntax()
    {
        $syntax = new Syntax('? equals ?', 'stdClass::method');
        $this->assert($syntax->getSyntax())->equals('? equals ?');
    }

    public function testGetClass()
    {
        $syntax = new Syntax('? equals ?', 'stdClass::method');
        $this->assert($syntax->getClass())->equals('stdClass');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Class 'FooBar' does not exist.
     */
    public function testClassMustExist()
    {
        new Syntax('? equals ?', 'FooBar::method');
    }

    public function testGetMethod()
    {
        $syntax = new Syntax('? equals ?', 'stdClass::method');
        $this->assert($syntax->getMethod())->equals('method');
    }

    public function testGetRawSyntax()
    {
        $syntax =
            new Syntax('?:int does not equal ?:string', 'stdClass::method');
        $this->assert($syntax->getRawSyntax())->equals('? does not equal ?');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Method must be in the form of class::method
     */
    public function testBadMethodFormat()
    {
        new Syntax('? equals ?', 'stdClass');
    }

    public function testDefaultDescriptionBlank()
    {
        $syntax = new Syntax('? equals ?', 'stdClass::method');
        $this->assert($syntax->getDescription())->isBlank;
    }

    public function testSettingDescription()
    {
        $syntax = new Syntax('? equals ?', 'stdClass::method');
        $syntax->setDescription('foo bar');
        $this->assert($syntax->getDescription())->equals('foo bar');
    }

    public function testMethodIsAllowedToBeNull()
    {
        $syntax = new Syntax('? equals ?');
        $this->assert($syntax->getMethod())->isNull;
    }

    // @todo testCapitolsAreNotAllowedInSyntax
}
