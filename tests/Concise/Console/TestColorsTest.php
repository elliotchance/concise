<?php

namespace Concise\Console;

use Concise\Console\Theme\DefaultTheme;
use Concise\Core\TestCase;

class TestColorsTest extends TestCase
{
    public function testEndsInNewLine()
    {
        $testColors = new TestColors();
        $this->assertString($testColors->renderAll(new DefaultTheme()))
            ->endsWith("\n");
    }
}
