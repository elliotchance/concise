<?php

namespace Concise\Console\Theme;

use \Concise\TestCase;

class DefaultThemeTest extends TestCase
{
    protected $theme;

    public function setUp()
    {
        parent::setUp();
        $this->theme = new DefaultTheme();
    }

    public function testThemeHasSuccess()
    {
        $this->assert($this->theme->getTheme(), has_key, 'success');
    }

    public function testThemeHasFailure()
    {
        $this->assert($this->theme->getTheme(), has_key, 'failure');
    }

    public function testThemeHasError()
    {
        $this->assert($this->theme->getTheme(), has_key, 'error');
    }
}
