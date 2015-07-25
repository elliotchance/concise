<?php

namespace Concise\Console;

class Terminal
{
    public function getColumns()
    {
        if (!getenv('TERM')) {
            return 80;
        }
        return (int)`tput cols`;
    }
}
