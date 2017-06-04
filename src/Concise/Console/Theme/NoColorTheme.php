<?php

namespace Concise\Console\Theme;

class NoColorTheme extends AbstractTheme
{
    public function getValueIntegerColor()
    {
        return ThemeColor::NONE;
    }

    public function getValueFloatColor()
    {
        return ThemeColor::NONE;
    }

    public function getValueStringColor()
    {
        return ThemeColor::NONE;
    }

    public function getValueClosureColor()
    {
        return ThemeColor::NONE;
    }

    public function getValueNullColor()
    {
        return ThemeColor::NONE;
    }

    public function getValueBooleanColor()
    {
        return ThemeColor::NONE;
    }

    public function getStatusPassedColor()
    {
        return ThemeColor::NONE;
    }

    public function getStatusFailureColor()
    {
        return ThemeColor::NONE;
    }

    public function getStatusErrorColor()
    {
        return ThemeColor::NONE;
    }

    public function getStatusSkippedColor()
    {
        return ThemeColor::NONE;
    }

    public function getStatusIncompleteColor()
    {
        return ThemeColor::NONE;
    }

    public function getStatusRiskyColor()
    {
        return ThemeColor::NONE;
    }

    public function getStackTraceColor()
    {
        return ThemeColor::NONE;
    }
}
