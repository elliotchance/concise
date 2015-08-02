<?php

namespace Concise\Matcher;

class Module
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var array
     */
    protected $syntaxes;

    public function __construct($name, array $syntaxes = array())
    {
        $this->name = $name;
        $this->syntaxes = $syntaxes;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getSyntaxes()
    {
        return $this->syntaxes;
    }
}
