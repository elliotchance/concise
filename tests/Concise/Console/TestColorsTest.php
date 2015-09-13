<?php

namespace Concise\Console;

use Concise\Core\TestCase;

class TestColorsTest extends TestCase
{
    public function testEndsInNewLine()
    {
        $testColors = new TestColors();
        $this->assert($testColors->renderAll())->endsWith("\n");
    }
}
