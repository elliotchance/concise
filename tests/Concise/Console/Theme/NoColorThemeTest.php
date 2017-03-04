<?php

namespace Concise\Console\Theme;

/**
 * @group #339
 */
class NoColorThemeTest extends ThemeTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->theme = new NoColorTheme();
    }
}
