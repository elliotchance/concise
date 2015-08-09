<?php

namespace Concise\Matcher;

use Concise\Services\SyntaxRenderer;

abstract class AbstractMatcher
{
    /**
     * @param string $syntax
     * @param array  $data
     * @return string
     */
    public function renderFailureMessage($syntax, array $data = array())
    {
        $renderer = new SyntaxRenderer();

        return $renderer->render($syntax, $data);
    }
}
