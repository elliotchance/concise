<?php

namespace Concise\Services;

class ValueDescriptor
{
	public function describe($value)
	{
		return gettype($value);
	}
}
