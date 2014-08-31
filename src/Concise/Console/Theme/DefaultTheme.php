<?php

namespace Concise\Console\Theme;

class DefaultTheme
{
    public function getTheme()
    {
        return array(
            'success'    => 'green',
            'failure'    => 'red',
            'error'      => 'red',
            'skipped'    => 'blue',
            'incomplete' => 'yellow',
            'risky'      => 'yellow',
        );
    }
}
