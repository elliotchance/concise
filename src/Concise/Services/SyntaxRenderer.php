<?php

namespace Concise\Services;

use Concise\Console\Theme\DefaultTheme;
use Concise\Validation\ArgumentChecker;

class SyntaxRenderer
{
    /**
     * @param string $syntax
     * @param array  $data
     * @return string
     */
    public function render($syntax, array $data = array())
    {
        ArgumentChecker::check($syntax, 'string');

        $renderer = new ValueRenderer();
        $renderer->setTheme(new DefaultTheme());

        return preg_replace_callback(
            '/\?/',
            function () use (&$data, $renderer) {
                $r = $renderer->render(array_shift($data));

                return $r;
            },
            $syntax
        );
    }
}
