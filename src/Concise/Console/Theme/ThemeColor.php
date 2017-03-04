<?php

namespace Concise\Console\Theme;

/**
 * These are the available colors when using a ResultPrinter. They are derived
 * from generally available ANSI escapse codes.
 *
 * There is no black or white because these could clash with the background
 * color of the terminal (some people prefer a light or dark background). You
 * should use `NONE` to represent that you do not want the text to be colored
 * which will be black or white, depending on their terminal.
 *
 * https://en.wikipedia.org/wiki/ANSI_escape_code
 */
class ThemeColor
{
    const NONE = '';

    const RED = 'red';

    const GREEN = 'green';

    const YELLOW = 'yellow';
}
