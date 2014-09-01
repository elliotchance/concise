<?php

namespace Concise\Console\Theme;

use Concise\TestCase;
use PHPUnit_Runner_BaseTestRunner;

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
        $this->assert($this->theme->getTheme(), has_key, PHPUnit_Runner_BaseTestRunner::STATUS_PASSED);
    }

    public function testThemeHasFailure()
    {
        $this->assert($this->theme->getTheme(), has_key, PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE);
    }

    public function testThemeHasError()
    {
        $this->assert($this->theme->getTheme(), has_key, PHPUnit_Runner_BaseTestRunner::STATUS_ERROR);
    }

    public function testThemeHasSkipped()
    {
        $this->assert($this->theme->getTheme(), has_key, PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED);
    }

    public function testThemeHasIncomplete()
    {
        $this->assert($this->theme->getTheme(), has_key, PHPUnit_Runner_BaseTestRunner::STATUS_INCOMPLETE);
    }

    public function testThemeHasRisky()
    {
        $this->assert($this->theme->getTheme(), has_key, PHPUnit_Runner_BaseTestRunner::STATUS_RISKY);
    }
}
