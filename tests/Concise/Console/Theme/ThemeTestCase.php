<?php

namespace Concise\Console\Theme;

use Concise\TestCase;
use PHPUnit_Runner_BaseTestRunner;
use Colors\Color;

class ColorStub extends Color
{
    public function getStyles()
    {
        return $this->styles;
    }
}

abstract class ThemeTestCase extends TestCase
{
    protected $theme;

    public function keysProvider()
    {
        return array(
            array(PHPUnit_Runner_BaseTestRunner::STATUS_PASSED),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_ERROR),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_INCOMPLETE),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_RISKY),
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
        $this->assert($this->theme->getTheme(), has_key, $expectedKey);
    }

    /**
     * @dataProvider keysProvider
     */
    public function testThemeColorNameIsValid($expectedKey)
    {
        $theme = $this->theme->getTheme();
        $stub = new ColorStub();
        $this->assert($stub->getStyles(), has_key, $theme[$expectedKey]);
    }

    public function testMustImplementColorTheme()
    {
        $this->assert($this->theme, instance_of, 'Concise\Console\Theme\ThemeInterface');
    }

    public function testMustExtendAbstractTheme()
    {
        $this->assert($this->theme, instance_of, 'Concise\Console\Theme\AbstractTheme');
    }
}
