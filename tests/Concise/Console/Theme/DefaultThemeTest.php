<?php

namespace Concise\Console\Theme;

use \Concise\TestCase;

class DefaultTest extends TestCase
{
    public function testThemeHasSuccess()
    {
        $theme = new DefaultTheme();
        $this->assert($theme->getTheme(), has_key, 'success');
    }
}
