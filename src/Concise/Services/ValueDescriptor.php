<?php

namespace Concise\Services;

class ValueDescriptor
{
	public function describe($value)
	{
		if(is_int($value)) {
			return 'integer';
		}
		return 'string';
	}
}
