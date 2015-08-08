<?php

namespace Concise\Modules\Arrays;

class HasItems extends HasItem
{
    public function supportedSyntaxes()
    {
        return array(
        );
    }

    public function match($syntax, array $data = array())
    {
        if (count($data[1]) === 0) {
            return true;
        }
        foreach ($data[1] as $key => $value) {
            if (!parent::match(
                $data[0],
                array($data[0], array($key => $value))
            )
            ) {
                return false;
            }
        }

        return true;
    }
}
