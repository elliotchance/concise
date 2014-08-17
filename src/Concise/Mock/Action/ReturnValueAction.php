<?php

namespace Concise\Mock\Action;

class ReturnValueAction extends AbstractCachingAction
{
    public function getActionCode()
    {
        return parent::getActionCode() . "return is_object(\$v) ? clone \$v : \$v;";
    }
}
