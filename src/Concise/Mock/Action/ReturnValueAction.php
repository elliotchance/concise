<?php

namespace Concise\Mock\Action;

class ReturnValueAction extends AbstractAction
{
    /**
	 * @var array
	 */
    public static $cache = array();

    /**
	 * Each time a ReturnValueAction is instantiated it will generate a new cache key.
	 * @var string
	 */
    protected $cacheKey;

    /**
	 * @param array $values
	 */
    public function __construct(array $values)
    {
        $this->cacheKey = md5(rand() . time());
        self::$cache[$this->cacheKey] = $values;
        self::$cache[$this->cacheKey . 'i'] = 0;
    }

    public function getActionCode()
    {
        return <<<EOF
\$i = \Concise\Mock\Action\ReturnValueAction::\$cache['{$this->cacheKey}i'];
\$vs = \Concise\Mock\Action\ReturnValueAction::\$cache['{$this->cacheKey}'];
\$v = \$vs[\$i];
if(count(\$vs) > 1) {
    ++\Concise\Mock\Action\ReturnValueAction::\$cache['{$this->cacheKey}i'];
}
return is_object(\$v) ? clone \$v : \$v;
EOF;
    }

    /**
	 * @return mixed
	 */
    public function getValue()
    {
        return self::$cache[$this->cacheKey];
    }
}
