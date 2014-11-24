<?php

namespace Concise\Console\Theme;

class DefaultThemeTest extends ThemeTestCase
{
    protected $theme;

    public function setUp()
    {
        parent::setUp();
        $this->theme = new DefaultTheme();
    }
}
