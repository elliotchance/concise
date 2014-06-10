<?php

namespace Concise\Services;

class DataTypeChecker
{
	protected $excludeMode = false;

	public function check(array $acceptedTypes, $value)
	{
		if(count($acceptedTypes) === 0) {
			return true;
		}

		if($this->excludeMode === true) {
			return $this->checkExclude($acceptedTypes, $value);
		}
		return $this->checkInclude($acceptedTypes, $value);
	}

	protected function checkInclude(array $acceptedTypes, $value)
	{
		foreach($acceptedTypes as $acceptedType) {
			if($this->matches($acceptedType, $value)) {
				return true;
			}
		}
		$accepts = implode(' or ', $acceptedTypes);
		throw new \InvalidArgumentException($this->getType($value) . ' not found in ' . $accepts);
	}

	protected function checkExclude(array $acceptedTypes, $value)
	{
		foreach($acceptedTypes as $acceptedType) {
			if($this->matches($acceptedType, $value)) {
				$accepts = implode(' or ', $acceptedTypes);
				throw new \InvalidArgumentException($this->getType($value) . ' must not be ' . $accepts);
			}
		}
		return true;
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

	public function setExcludeMode()
	{
		$this->excludeMode = true;
	}
}
