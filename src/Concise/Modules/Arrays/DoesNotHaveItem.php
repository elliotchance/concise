<?php

namespace Concise\Modules\Arrays;

class DoesNotHaveItem extends HasItem
{
    const SPLIT_SYNTAX = '?:array does not have key ?:string with value ?';

    public function supportedSyntaxes()
    {
        return array(
        );
    }

    public function match($syntax, array $data = array())
    {
        if ($syntax === self::SPLIT_SYNTAX) {
            return !parent::match(
                null,
                array($data[0], array($data[1] => $data[2]))
            );
        }

        return !parent::match(null, $data);
    }

    public function getTags()
    {
        return array();
    }
}
