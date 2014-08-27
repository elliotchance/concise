<?php

namespace Concise\Console\Theme;

class DefaultTheme
{
    public function getTheme()
    {
        return [
            'success' => 'green',
            'failure' => 'red',
        ];
    }
}
