<?php

namespace Concise\Console\Theme;

interface ThemeInterface
{
    /**
     * @return integer
     */
    public function getColorForPHPUnitStatus($status);

    /**
     * @return integer
     */
    public function getValueIntegerColor();

    /**
     * @return integer
     */
    public function getValueFloatColor();

    /**
     * @return integer
     */
    public function getValueStringColor();

    /**
     * @return integer
     */
    public function getValueClosureColor();

    /**
     * @return integer
     */
    public function getValueNullColor();

    /**
     * @return integer
     */
    public function getValueBooleanColor();

    /**
     * @return integer
     */
    public function getStatusPassedColor();

    /**
     * @return integer
     */
    public function getStatusFailureColor();

    /**
     * @return integer
     */
    public function getStatusErrorColor();

    /**
     * @return integer
     */
    public function getStatusSkippedColor();

    /**
     * @return integer
     */
    public function getStatusIncompleteColor();

    /**
     * @return integer
     */
    public function getStatusRiskyColor();

    /**
     * @return integer
     */
    public function getStackTraceColor();
}
