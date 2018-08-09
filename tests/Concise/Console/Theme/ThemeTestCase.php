<?php

namespace Concise\Console\Theme;

use Colors\Color;
use Concise\Core\TestCase;
use PHPUnit\Runner\BaseTestRunner;

class ColorStub extends Color
{
    public function getStyles()
    {
        return $this->styles;
    }
}

abstract class ThemeTestCase extends TestCase
{
    /**
     * @var DefaultTheme
     */
    protected $theme;

    public function keysProvider()
    {
        return array(
            array(BaseTestRunner::STATUS_PASSED),
            array(BaseTestRunner::STATUS_FAILURE),
            array(BaseTestRunner::STATUS_ERROR),
            array(BaseTestRunner::STATUS_SKIPPED),
            array(BaseTestRunner::STATUS_INCOMPLETE),
            array(BaseTestRunner::STATUS_RISKY),
            array('value.integer'),
            array('value.float'),
            array('value.string'),
            array('value.closure'),
            array('value.null'),
            array('value.boolean'),
        );
    }

    /**
     * @dataProvider keysProvider
     */
    public function testThemeHasKey($expectedKey)
    {
        $this->assertArray($this->theme->getTheme())->hasKey($expectedKey);
    }

    /**
     * @dataProvider keysProvider
     */
    public function testThemeColorNameIsValid($expectedKey)
    {
        $theme = $this->theme->getTheme();
        $stub = new ColorStub();
        $this->assertArray($stub->getStyles())->hasKey($theme[$expectedKey]);
    }

    public function testMustImplementColorTheme()
    {
        $this->assert($this->theme)
            ->isAnInstanceOf('Concise\Console\Theme\ThemeInterface');
    }

    public function testMustExtendAbstractTheme()
    {
        $this->assert($this->theme)
            ->isAnInstanceOf('Concise\Console\Theme\AbstractTheme');
    }
}
