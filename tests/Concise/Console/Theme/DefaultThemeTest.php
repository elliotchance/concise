<?php

namespace Concise\Console\Theme;

class DefaultThemeTest extends ThemeTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->theme = new DefaultTheme();
    }
}
