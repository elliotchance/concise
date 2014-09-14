<?php

namespace Concise\Services;

use Concise\TestCase;
use Colors\Color;

class SyntaxRendererTest extends TestCase
{
    public function testCanSubstituteValuesFromArrayIntoPlaceholders()
    {
        $renderer = new SyntaxRenderer();
        $data = array(1, '2', 3.1);
        $c = new Color();
        $expected = (string) $c('1')->red . ' is ' . (string) $c('"2"')->yellow . ' bla ' . (string) $c(3.1)->magenta;
        $this->assert($expected, equals, $renderer->render('? is ? bla ?', $data));
    }
}
