<?php

namespace Concise\Syntax\Token;

use Concise\Syntax\Token;

class Attribute extends Token
{
    /**
	 * @var array
	 */
    protected $acceptedTypes = array();

    /**
	 * @param string $value
	 */
    public function __construct($value)
    {
        parent::__construct($value);
        $pos = strpos($value, ':');
        if ($pos !== false) {
            $this->acceptedTypes = explode(',', substr($value, $pos + 1));
            $this->value = '?';
        }
    }

    /**
	 * @return array
	 */
    public function getAcceptedTypes()
    {
        return $this->acceptedTypes;
    }
}
