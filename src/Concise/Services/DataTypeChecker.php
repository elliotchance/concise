<?php

namespace Concise\Services;

class DataTypeChecker
{
	public function check($accepts, $value)
	{
		if($accepts === 'int') {
			if(!is_int($value)) {
				throw new \InvalidArgumentException();
			}
		}
		return true;
	}
}
