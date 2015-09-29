<?php

namespace Concise\Core;

use Colors\Color;
use Concise\Core\TestCase;

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
        $c = new Color();
        $expected = (string)$c('1')->red . ' is ' . (string)$c('"2"')->yellow .
            ' bla ' . (string)$c(3.1)->magenta;
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
        $this->assertString($this->renderer->render('?', array(fopen('.', 'r'))))
            ->matches('/Resource id #\\d+/');
    }
}
