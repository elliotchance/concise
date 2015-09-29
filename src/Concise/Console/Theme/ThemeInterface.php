<?php

namespace Concise\Console\Theme;

interface ThemeInterface
{
    /**
     * @return array
     */
    public function getTheme();

    /**
     * @return string
     */
    public function getValueIntegerColor();

    /**
     * @return string
     */
    public function getValueFloatColor();

    /**
     * @return string
     */
    public function getValueStringColor();

    /**
     * @return string
     */
    public function getValueClosureColor();

    /**
     * @return string
     */
    public function getValueNullColor();

    /**
     * @return string
     */
    public function getValueBooleanColor();

    /**
     * @return string
     */
    public function getStatusPassedColor();

    /**
     * @return string
     */
    public function getStatusFailureColor();

    /**
     * @return string
     */
    public function getStatusErrorColor();

    /**
     * @return string
     */
    public function getStatusSkippedColor();

    /**
     * @return string
     */
    public function getStatusIncompleteColor();

    /**
     * @return string
     */
    public function getStatusRiskyColor();
}
