<?php

namespace Concise\Mock\Action;

class ReturnPropertyAction extends AbstractAction
{
    /**
     * @var string
     */
    protected $property;

    /**
     * @param string $property
     */
    public function __construct($property)
    {
        $this->property = $property;
    }

    /**
     * @return string
     */
    public function getActionCode()
    {
        return
"
if (property_exists(\$this, \"{$this->property}\")) {
	return \$this->{$this->property};
}
throw new \RuntimeException(\"Property '{$this->property}' does not exist for \" . get_class(\$this));
";
    }
}
