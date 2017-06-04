<?php

namespace Concise\Core;

use Concise\Console\Theme\DefaultTheme;
use Concise\Console\Theme\ThemeInterface;

class SyntaxRenderer
{
    /**
     * @var ThemeInterface
     */
    protected $theme;

    public function __construct(ThemeInterface $theme)
    {
        $this->theme = $theme;
    }

    /**
     * @param string $syntax
     * @param array  $data
     * @return string
     */
    public function render($syntax, array $data = array())
    {
        ArgumentChecker::check($syntax, 'string');
        $renderer = new ValueRenderer($this->theme);
        
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
