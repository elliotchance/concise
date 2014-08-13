<?php

namespace Concise\Matcher;

use \Concise\Services\SyntaxRenderer;

abstract class AbstractMatcher
{
    /**
	 * @param string $syntax
	 * @return bool
	 */
    abstract public function match($syntax, array $data = array());

    /**
	 * @return array Syntaxes this matcher can understand.
	 */
    abstract public function supportedSyntaxes();

    /**
	 * @param string $syntax
	 * @return string
	 */
    public function renderFailureMessage($syntax, array $data = array())
    {
        $renderer = new SyntaxRenderer();

        return $renderer->render($syntax, $data);
    }

    /**
	 * @return array
	 */
    abstract public function getTags();
}
