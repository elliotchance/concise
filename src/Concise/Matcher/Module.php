<?php

namespace Concise\Matcher;

use InvalidArgumentException;

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
    protected $syntaxes = [];

    public function __construct($name, array $syntaxes = array())
    {
        $this->name = $name;
        $this->setSyntaxes($syntaxes);
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

    /**
     * @return Syntax[]
     */
    public function getSyntaxes()
    {
        return $this->syntaxes;
    }

    public function setSyntaxes(array $syntaxes)
    {
        $this->syntaxes = [];
        foreach ($syntaxes as $syntax => $data) {
            if (!array_key_exists('method', $data)) {
                throw new InvalidArgumentException(
                    "Missing 'method' for '$syntax'."
                );
            }
            $s = new Syntax($syntax, $data['method']);
            if (array_key_exists('description', $data)) {
                $s->setDescription(trim($data['description']));
            }
            $this->syntaxes[] = $s;
        }
    }
}
