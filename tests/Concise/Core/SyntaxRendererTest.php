<?php

namespace Concise\Core;

use Concise\Console\ResultPrinter\Utilities\ColorText;
use Concise\Console\Theme\ThemeColor;

class SyntaxRendererTest extends TestCase
{
    /**
     * @var SyntaxRenderer
     */
    protected $renderer;

    public function setUp()
    {
        parent::setUp();
        $this->renderer = new SyntaxRenderer();
    }

    public function testCanSubstituteValuesFromArrayIntoPlaceholders()
    {
        $data = array(1, '2', 3.1);
        $c = new ColorText();
        $expected = $c->color('1', ThemeColor::RED) .
            ' is ' .
            $c->color('"2"', ThemeColor::YELLOW) .
            ' bla ' .
            $c->color(3.1, ThemeColor::MAGENTA);
        $this->assert($expected)
            ->equals($this->renderer->render('? is ? bla ?', $data));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected string, but got integer for argument 1
     */
    public function testSyntaxMustBeAString()
    {
        $this->renderer->render(123);
    }

    /**
     * @group #250
     */
    public function testResourceRendering()
    {
        $this->assertString(
            $this->renderer->render('?', array(fopen('.', 'r')))
        )
            ->matches('/Resource id #\\d+/');
    }
}
