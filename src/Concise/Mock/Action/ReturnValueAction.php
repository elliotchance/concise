<?php

namespace Concise\Mock\Action;

class ReturnValueAction extends AbstractCachingAction
{
    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        parent::__construct($values);
        self::$cache[$this->cacheKey . 'i'] = 0;
    }

    /**
     * @return string
     */
    public function getActionCode()
    {
        return <<<EOF
\$i = \Concise\Mock\Action\ReturnValueAction::\$cache['{$this->cacheKey}i'];
\$vs = \Concise\Mock\Action\ReturnValueAction::\$cache['{$this->cacheKey}'];
if (\$i >= count(\$vs)) {
    throw new \Exception("Only \$i return values have been provided.");
}
\$v = \$vs[\$i];
if (count(\$vs) > 1) {
    ++\Concise\Mock\Action\ReturnValueAction::\$cache['{$this->cacheKey}i'];
}
return is_object(\$v) ? clone \$v : \$v;
EOF;
    }
}
