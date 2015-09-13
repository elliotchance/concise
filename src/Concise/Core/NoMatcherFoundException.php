<?php

namespace Concise\Core;

use Exception;

class NoMatcherFoundException extends Exception
{
    /**
     * @var array
     */
    protected $syntaxes;

    public function __construct(array $syntaxes)
    {
        $message =
            "No such matcher for syntax '" . implode("' or '", $syntaxes) .
            "'.";
        parent::__construct($message);
        $this->syntaxes = $syntaxes;
    }

    /**
     * @return array
     */
    public function getSyntaxes()
    {
        return $this->syntaxes;
    }
}
