<?php

namespace Concise\Services;

use \Concise\TestCase;

class SyntaxRendererTest extends TestCase
{
    public function testCanSubstituteValuesFromArrayIntoPlaceholders()
    {
        $renderer = new SyntaxRenderer();
        $data = array(1, '2', 3.1);
        $this->assert('1 is "2" bla 3.1', equals, $renderer->render('? is ? bla ?', $data));
    }
}
