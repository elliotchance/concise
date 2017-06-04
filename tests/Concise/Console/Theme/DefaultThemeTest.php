<?php

namespace Concise\Console\Theme;

class DefaultThemeTest extends ThemeTestCase
{
    /**
     * @return ThemeInterface
     */
    protected function getTheme()
    {
        return new DefaultTheme();
    }
}
