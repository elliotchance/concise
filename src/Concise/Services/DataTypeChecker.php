<?php

namespace Concise\Services;

class DataTypeChecker
{
	public function check($accepts, $value)
	{
		if($accepts === '') {
			return true;
		}

		$acceptedTypes = explode(',', $accepts);
		foreach($acceptedTypes as $acceptedType) {
			if($this->matches($acceptedType, $value)) {
				return true;
			}
		}
		throw new \InvalidArgumentException($this->getType($value) . ' not found in ' . $accepts);
	}

	protected function getType($value)
	{
		if(is_callable($value)) {
			return 'callable';
		}
		return gettype($value);
	}

	protected function matches($type, $value)
	{
		return $this->simpleType($type) === $this->simpleType($this->getType($value));
	}

	protected function simpleType($type)
	{
		if($type === 'integer') {
			$type = 'int';
		}
		else if($type === 'double') {
			$type = 'float';
		}
		return $type;
	}
}
