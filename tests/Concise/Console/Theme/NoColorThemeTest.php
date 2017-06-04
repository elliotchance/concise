<?php

namespace Concise\Console\Theme;

/**
 * @group #339
 */
class NoColorThemeTest extends ThemeTestCase
{
    /**
     * @return ThemeInterface
     */
    protected function getTheme()
    {
        return new NoColorTheme();
    }
}
