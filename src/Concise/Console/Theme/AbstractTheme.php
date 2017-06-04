<?php

namespace Concise\Console\Theme;

use PHPUnit_Runner_BaseTestRunner;

abstract class AbstractTheme implements ThemeInterface
{
    /**
     * @return integer
     */
    public function getColorForPHPUnitStatus($status)
    {
        switch ($status) {
            case PHPUnit_Runner_BaseTestRunner::STATUS_PASSED:
                return $this->getStatusPassedColor();

            case PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE:
                return $this->getStatusFailureColor();

            case PHPUnit_Runner_BaseTestRunner::STATUS_ERROR:
                return $this->getStatusErrorColor();

            case PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED:
                return $this->getStatusSkippedColor();

            case PHPUnit_Runner_BaseTestRunner::STATUS_INCOMPLETE:
                return $this->getStatusIncompleteColor();

            case PHPUnit_Runner_BaseTestRunner::STATUS_RISKY:
                return $this->getStatusRiskyColor();
        }

        // It is either an invalid status or a new status that has been added to
        // PHPUnit. Either way default to not applying any color.
        return ThemeColor::NONE;
    }
}
