<?php

namespace Concise\Console\Theme;

class DefaultTheme extends AbstractTheme
{
    public function getValueIntegerColor()
    {
        return ThemeColor::RED;
    }

    public function getValueFloatColor()
    {
        return ThemeColor::MAGENTA;
    }

    public function getValueStringColor()
    {
        return ThemeColor::YELLOW;
    }

    public function getValueClosureColor()
    {
        return ThemeColor::CYAN;
    }

    public function getValueNullColor()
    {
        return ThemeColor::BLUE;
    }

    public function getValueBooleanColor()
    {
        return ThemeColor::GREEN;
    }

    public function getStatusPassedColor()
    {
        return ThemeColor::GREEN;
    }

    public function getStatusFailureColor()
    {
        return ThemeColor::RED;
    }

    public function getStatusErrorColor()
    {
        return ThemeColor::RED;
    }

    public function getStatusSkippedColor()
    {
        return ThemeColor::BLUE;
    }

    public function getStatusIncompleteColor()
    {
        return ThemeColor::YELLOW;
    }

    public function getStatusRiskyColor()
    {
        return ThemeColor::YELLOW;
    }

    public function getStackTraceColor()
    {
        return ThemeColor::GRAY;
    }
}
