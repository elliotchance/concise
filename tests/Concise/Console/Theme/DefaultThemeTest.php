<?php

namespace Concise\Console\Theme;

use \Concise\TestCase;

class DefaultThemeTest extends TestCase
{
    public function testThemeHasSuccess()
    {
        $theme = new DefaultTheme();
        $this->assert($theme->getTheme(), has_key, 'success');
    }

    public function testThemeHasFailure()
    {
        $theme = new DefaultTheme();
        $this->assert($theme->getTheme(), has_key, 'failure');
    }
}
