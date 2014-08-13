<?php

namespace Concise\Services;

class ValueDescriptor
{
    /**
	 * @param  mixed $value
	 * @return string
	 */
    public function describe($value)
    {
        if (is_object($value)) {
            return get_class($value);
        }

        return gettype($value);
    }
}
