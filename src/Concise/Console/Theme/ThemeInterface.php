<?php

namespace Concise\Console\Theme;

interface ThemeInterface
{
    /**
     * @return array
     */
    public function getTheme();

    public function getValueIntegerColor();

    public function getValueFloatColor();

    public function getValueStringColor();

    public function getValueClosureColor();

    public function getValueNullColor();

    public function getValueBooleanColor();

    public function getStatusPassedColor();

    public function getStatusFailureColor();

    public function getStatusErrorColor();

    public function getStatusSkippedColor();

    public function getStatusIncompleteColor();

    public function getStatusRiskyColor();
}
