<?php

namespace Concise\Console;

use Concise\TestCase;

class TestColorsTest extends TestCase
{
    public function testEndsInNewLine()
    {
        $testColors = new TestColors();
        $this->assert($testColors->renderAll(), ends_with, "\n");
    }
}
