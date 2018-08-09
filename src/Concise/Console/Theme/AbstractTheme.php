<?php

namespace Concise\Console\Theme;

use PHPUnit\Runner\BaseTestRunner;

abstract class AbstractTheme implements ThemeInterface
{
    /**
     * @return array
     */
    public function getTheme()
    {
        return array(
            BaseTestRunner::STATUS_PASSED => $this->getStatusPassedColor(),
            BaseTestRunner::STATUS_FAILURE => $this->getStatusFailureColor(),
            BaseTestRunner::STATUS_ERROR => $this->getStatusErrorColor(),
            BaseTestRunner::STATUS_SKIPPED => $this->getStatusSkippedColor(),
            BaseTestRunner::STATUS_INCOMPLETE => $this->getStatusIncompleteColor(),
            BaseTestRunner::STATUS_RISKY => $this->getStatusRiskyColor(),
            'value.integer' => $this->getValueIntegerColor(),
            'value.float' => $this->getValueFloatColor(),
            'value.string' => $this->getValueStringColor(),
            'value.closure' => $this->getValueClosureColor(),
            'value.null' => $this->getValueNullColor(),
            'value.boolean' => $this->getValueBooleanColor(),
        );
    }

    public function getValueIntegerColor()
    {
        return 'red';
    }

    public function getValueFloatColor()
    {
        return 'magenta';
    }

    public function getValueStringColor()
    {
        return 'yellow';
    }

    public function getValueClosureColor()
    {
        return 'cyan';
    }

    public function getValueNullColor()
    {
        return 'blue';
    }

    public function getValueBooleanColor()
    {
        return 'green';
    }

    public function getStatusPassedColor()
    {
        return 'green';
    }

    public function getStatusFailureColor()
    {
        return 'red';
    }

    public function getStatusErrorColor()
    {
        return 'red';
    }

    public function getStatusSkippedColor()
    {
        return 'blue';
    }

    public function getStatusIncompleteColor()
    {
        return 'yellow';
    }

    public function getStatusRiskyColor()
    {
        return 'yellow';
    }
}
