<?php

namespace Concise\Console\Theme;

use PHPUnit_Runner_BaseTestRunner;

abstract class AbstractTheme implements ThemeInterface
{
    /**
     * @return array
     */
    public function getTheme()
    {
        return array(
            PHPUnit_Runner_BaseTestRunner::STATUS_PASSED     => $this->getStatusPassedColor(),
            PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE    => $this->getStatusFailureColor(),
            PHPUnit_Runner_BaseTestRunner::STATUS_ERROR      => $this->getStatusErrorColor(),
            PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED    => $this->getStatusSkippedColor(),
            PHPUnit_Runner_BaseTestRunner::STATUS_INCOMPLETE => $this->getStatusIncompleteColor(),
            PHPUnit_Runner_BaseTestRunner::STATUS_RISKY      => $this->getStatusRiskyColor(),
            'value.integer'                                  => $this->getValueIntegerColor(),
            'value.float'                                    => $this->getValueFloatColor(),
            'value.string'                                   => $this->getValueStringColor(),
            'value.closure'                                  => $this->getValueClosureColor(),
            'value.null'                                     => $this->getValueNullColor(),
            'value.boolean'                                  => $this->getValueBooleanColor(),
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
