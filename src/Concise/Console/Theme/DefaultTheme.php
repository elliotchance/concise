<?php

namespace Concise\Console\Theme;

use PHPUnit_Runner_BaseTestRunner;

class DefaultTheme
{
    public function getTheme()
    {
        return array(
            PHPUnit_Runner_BaseTestRunner::STATUS_PASSED     => 'green',
            PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE    => 'red',
            PHPUnit_Runner_BaseTestRunner::STATUS_ERROR      => 'red',
            PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED    => 'blue',
            PHPUnit_Runner_BaseTestRunner::STATUS_INCOMPLETE => 'yellow',
            PHPUnit_Runner_BaseTestRunner::STATUS_RISKY      => 'yellow',
            'value.integer'                                  => 'magenta',
            'value.float'                                    => 'magenta',
            'value.string'                                   => 'yellow',
            'value.closure'                                  => 'blue',
        );
    }
}
