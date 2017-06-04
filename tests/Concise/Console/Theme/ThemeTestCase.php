<?php

namespace Concise\Console\Theme;

use Concise\Core\TestCase;

abstract class ThemeTestCase extends TestCase
{
    /**
     * @return ThemeInterface
     */
    abstract protected function getTheme();

    public function colors()
    {
        return array(
            array($this->getTheme()->getValueIntegerColor()),
            array($this->getTheme()->getValueFloatColor()),
            array($this->getTheme()->getValueStringColor()),
            array($this->getTheme()->getValueClosureColor()),
            array($this->getTheme()->getValueNullColor()),
            array($this->getTheme()->getValueBooleanColor()),
            array($this->getTheme()->getStatusPassedColor()),
            array($this->getTheme()->getStatusFailureColor()),
            array($this->getTheme()->getStatusErrorColor()),
            array($this->getTheme()->getStatusSkippedColor()),
            array($this->getTheme()->getStatusIncompleteColor()),
            array($this->getTheme()->getStatusRiskyColor()),
            array($this->getTheme()->getStackTraceColor()),
        );
    }

    /**
     * @dataProvider keysProvider
     * @group #339
     */
    public function testThemeColorIsValid($color)
    {
        $this->assertArray(ThemeColor::getAllColors())
            ->hasValue($color);
    }

    public function testMustImplementColorTheme()
    {
        $this->assert($this->getTheme())
            ->isAnInstanceOf('Concise\Console\Theme\ThemeInterface');
    }

    public function testMustExtendAbstractTheme()
    {
        $this->assert($this->getTheme())
            ->isAnInstanceOf('Concise\Console\Theme\AbstractTheme');
    }
}
