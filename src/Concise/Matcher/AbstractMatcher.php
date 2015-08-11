<?php

namespace Concise\Matcher;

use Concise\Services\SyntaxRenderer;

abstract class AbstractMatcher
{
    protected $data = array();

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

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }
}
