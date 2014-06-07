<?php

namespace Concise\Services;

class ValueDescriptor
{
	public function describe($value)
	{
		if(is_object($value)) {
			return get_class($value);
		}
		return gettype($value);
	}
}
